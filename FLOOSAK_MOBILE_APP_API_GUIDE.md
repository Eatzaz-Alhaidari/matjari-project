# Floosak Wallet Mobile App Integration Guide

This document describes the backend API changes and the mobile app work required to support Floosak Wallet payments in the existing marketplace checkout flow.

## 1. Backend Changes Summary

The backend now supports Floosak Wallet as an API-driven payment method for mobile checkout.

Implemented backend capabilities:

- Floosak payment method returned from `GET /api/v1/payment-methods` when enabled and fully configured.
- Payment initiation endpoint for mobile orders.
- OTP confirmation endpoint.
- Payment status polling endpoint.
- Backend uses the authenticated user's `users.phone` as the Floosak customer phone.
- Mobile app must not send or override the Floosak customer phone.
- Backend stores payment attempts for idempotency and reconciliation.
- Backend background job checks unresolved payments using Floosak Check Status.
- No webhook is implemented because the supplied Floosak documentation does not define webhook payloads or verification.

Required backend environment values:

```env
FLOOSAK_ENABLED=true
FLOOSAK_BASE_URL=https://staging.fintech-expert.net
FLOOSAK_MERCHANT_PHONE=<merchant-login-phone>
FLOOSAK_MERCHANT_PASSWORD=<merchant-password>
FLOOSAK_SOURCE_WALLET_ID=<merchant-wallet-id>
```

Important: `FLOOSAK_SOURCE_WALLET_ID` is the merchant wallet id sent to Floosak as `source_wallet_id`. Until this value is set to a positive integer, the backend will not expose `floosak_wallet` in `/api/v1/payment-methods`.

## 2. Mobile Payment Flow

The mobile app checkout flow should be:

1. Fetch available payment methods.
2. Show "Floosak Wallet" if returned by the backend.
3. Customer selects Floosak Wallet.
4. Mobile creates the order using `payment_method = floosak_wallet`.
5. Mobile calls the Floosak initiate endpoint for that order.
6. Backend sends payment request to Floosak using:
   - Merchant wallet id from backend config.
   - Customer phone from `users.phone`.
   - Order amount from the order.
7. If backend returns `requires_otp = true`, show OTP input screen.
8. Customer enters OTP.
9. Mobile calls the confirm endpoint.
10. If payment status becomes `completed`, show payment success and continue to order success.
11. If payment is unknown or pending, show processing state and poll the status endpoint.

Sandbox note: Floosak documentation says sandbox OTP is always `123456`.

## 3. Authentication

The new Floosak payment endpoints require the mobile user's Sanctum bearer token.

Use:

```http
Authorization: Bearer {mobile_user_token}
Accept: application/json
Content-Type: application/json
```

The existing order creation endpoint currently accepts `user_id` in the request body. The Floosak payment endpoints validate ownership using the authenticated user token.

## 4. API Response Envelope

Successful responses use:

```json
{
  "status": true,
  "message": "Message text",
  "data": {}
}
```

Error responses use:

```json
{
  "status": false,
  "message": "Error message",
  "errors": {}
}
```

## 5. API Endpoints

### 5.1 Get Payment Methods

Use this endpoint to render checkout payment options.

```http
GET /api/v1/payment-methods
```

Authentication: not required by the current backend route.

Example response when Floosak is enabled:

```json
{
  "status": true,
  "message": "تم جلب طرق الدفع بنجاح",
  "data": [
    {
      "id": "cash",
      "name": "الدفع عند الاستلام",
      "icon": "cash-outline"
    },
    {
      "id": "wallet",
      "name": "المحفظة الإلكترونية",
      "icon": "wallet-outline"
    },
    {
      "id": "bank_transfer",
      "name": "تحويل بنكي",
      "icon": "card-outline"
    },
    {
      "id": "floosak_wallet",
      "name": "محفظة فلوسك",
      "icon": "wallet-outline"
    }
  ]
}
```

Mobile app change:

- Add a checkout payment option when `id = floosak_wallet`.
- Do not hardcode the option if it is not returned by the backend.

### 5.2 Create Order With Floosak Payment Method

Use the existing order creation endpoint.

```http
POST /api/v1/orders
```

Current request shape:

```json
{
  "user_id": 1,
  "store_id": 1,
  "products": [
    {
      "product_id": 10,
      "quantity": 2
    }
  ],
  "total_price": 100,
  "payment_method": "floosak_wallet",
  "address": "Customer address",
  "city": "Sanaa"
}
```

Expected response:

```json
{
  "status": true,
  "message": "تم استقبال الطلب بنجاح",
  "data": {
    "id": 123,
    "order_number": "ORD-XXXXXXXX",
    "user_id": 1,
    "store_id": 1,
    "total_amount": "100.00",
    "payment_method": "floosak_wallet",
    "payment_status": "pending",
    "status": "pending",
    "order_items": []
  }
}
```

Mobile app change:

- When customer selects Floosak, send `payment_method = floosak_wallet`.
- Keep the order in a pending payment UI state until Floosak confirmation completes.

### 5.3 Initiate Floosak Payment

This endpoint starts a Floosak payment for an existing order.

```http
POST /api/v1/orders/{order_id}/payments/floosak/initiate
```

Authentication: required.

Request body:

```json
{}
```

The mobile app must not send:

- Customer phone.
- Amount.
- Merchant wallet id.
- Purpose.

Those values are derived by the backend.

Example response:

```json
{
  "status": true,
  "message": "تم بدء عملية الدفع عبر محفظة فلوسك بنجاح",
  "data": {
    "payment_attempt_id": 55,
    "order_id": 123,
    "request_id": "4a7f8a70-58b0-4f79-9e3a-6d9df815af91",
    "gateway_purchase_id": "1699240",
    "gateway_transaction_id": null,
    "gateway_reference_id": "4633395571756870",
    "status": "pending",
    "gateway_status": {
      "en": "Pending",
      "ar": "معلقه"
    },
    "amount": "100.00",
    "net": "100.00",
    "fee": "1.00",
    "gross": "101.00",
    "requires_otp": true,
    "next_reconcile_at": null
  }
}
```

Mobile app change:

- Store `payment_attempt_id`.
- If `requires_otp = true`, navigate to OTP entry screen.
- If `status = send_unknown`, show "payment is being checked" and poll status.
- This endpoint is idempotent for active attempts: if mobile retries after timeout, backend returns the existing active attempt instead of creating a duplicate payment.

### 5.4 Confirm Floosak OTP

This endpoint confirms a pending Floosak payment using the OTP entered by the customer.

```http
POST /api/v1/payments/floosak/{payment_attempt_id}/confirm
```

Authentication: required.

Request body:

```json
{
  "otp": "123456"
}
```

Example completed response:

```json
{
  "status": true,
  "message": "تم تأكيد الدفع بنجاح",
  "data": {
    "payment_attempt_id": 55,
    "order_id": 123,
    "request_id": "4a7f8a70-58b0-4f79-9e3a-6d9df815af91",
    "gateway_purchase_id": "1699240",
    "gateway_transaction_id": "620453",
    "gateway_reference_id": "4633391771756870",
    "status": "completed",
    "gateway_status": {
      "en": "Completed",
      "ar": "مكتملة"
    },
    "amount": "100.00",
    "net": "100.00",
    "fee": "1.00",
    "gross": "101.00",
    "requires_otp": false,
    "next_reconcile_at": null
  }
}
```

Mobile app change:

- On `status = completed`, show payment success and order confirmation.
- On `status = pending`, keep OTP/payment pending UI.
- On `status = confirm_unknown`, show processing UI and poll status.
- Do not log OTP in mobile analytics, crash logs, or debug logs.

### 5.5 Get Floosak Payment Status

Use this endpoint for polling after pending or unknown states.

```http
GET /api/v1/payments/floosak/{payment_attempt_id}
```

Authentication: required.

Example response:

```json
{
  "status": true,
  "message": "تم جلب حالة الدفع بنجاح",
  "data": {
    "payment_attempt_id": 55,
    "order_id": 123,
    "request_id": "4a7f8a70-58b0-4f79-9e3a-6d9df815af91",
    "gateway_purchase_id": "1699240",
    "gateway_transaction_id": "620453",
    "gateway_reference_id": "4633391771756870",
    "status": "completed",
    "gateway_status": {
      "en": "Completed",
      "ar": "مكتملة"
    },
    "amount": "100.00",
    "net": "100.00",
    "fee": "1.00",
    "gross": "101.00",
    "requires_otp": false,
    "next_reconcile_at": null
  }
}
```

Mobile app change:

- Poll this endpoint when initiation or confirmation returns an unknown/pending state.
- Recommended polling: every 5 seconds for up to 60 seconds, then show a non-blocking "payment is still being verified" state.
- The backend background process continues reconciliation even if the mobile app stops polling.

## 6. Payment Attempt Status Values

The mobile app should handle these backend statuses:

| Status | Meaning | Mobile UI |
| --- | --- | --- |
| `initiating` | Backend created local attempt before sending to Floosak | Loading |
| `pending` | Floosak created purchase and OTP is required | Show OTP screen |
| `send_unknown` | Send request outcome is unclear | Processing, poll status |
| `send_failed` | Send request failed definitively | Show failure and allow retry |
| `confirming` | Backend is confirming OTP | Loading |
| `confirm_unknown` | OTP confirmation outcome is unclear | Processing, poll status |
| `completed` | Floosak payment completed and order is paid | Success |
| `failed` | Payment failed definitively | Failure |

Backend marks the order as paid only when Floosak returns `gateway_status.en = Completed`.

## 7. Mobile UI Changes Required

### Checkout Screen

- Add Floosak Wallet as a selectable payment method when returned from `/api/v1/payment-methods`.
- Display name: `محفظة فلوسك`.
- Do not ask user to enter a different wallet phone number.
- Explain that OTP will be sent/verified through Floosak for the account phone registered with the marketplace.

### OTP Screen

Show after payment initiation returns:

```json
"requires_otp": true
```

OTP screen should include:

- OTP input.
- Confirm button.
- Loading state while calling confirm API.
- Error message area.
- Retry confirm action.
- Back/cancel action that leaves the order unpaid.

Sandbox testing:

```text
Use OTP: 123456
```

### Processing Screen

Show when status is:

- `send_unknown`
- `confirm_unknown`
- `pending` after OTP submission

Behavior:

- Poll `GET /api/v1/payments/floosak/{payment_attempt_id}`.
- If status becomes `completed`, navigate to success.
- If status becomes `failed` or `send_failed`, show failure.
- If still unresolved after timeout, tell user payment is being verified and allow viewing order status later.

### Success Screen

Show when:

```json
"status": "completed"
```

Display:

- Order number.
- Paid amount.
- Payment method: Floosak Wallet.
- Gateway reference id if available.

### Failure Screen

Show when:

- API returns HTTP 422 validation error.
- API returns HTTP 403 ownership error.
- API returns HTTP 409 conflict.
- Attempt status is `failed` or `send_failed`.

Recommended actions:

- Allow retry initiation if no active attempt remains.
- Allow choosing another payment method if order remains unpaid.
- Show support/contact option if a gateway reference exists.

## 8. Important Mobile Rules

- Do not send `target_phone`; backend uses `users.phone`.
- Do not send payment `amount`; backend uses `orders.total_amount`.
- Do not send `source_wallet_id`; backend uses `FLOOSAK_SOURCE_WALLET_ID`.
- Do not mark the order paid on the client by itself.
- Treat backend `status = completed` as the only payment success signal.
- Never store or log OTP.
- On network timeout after initiation, call initiate again or poll if you already have `payment_attempt_id`.
- On network timeout after confirm, poll status instead of repeatedly submitting OTP.

## 9. Common Error Responses

Missing customer phone:

```json
{
  "status": false,
  "message": "رقم هاتف العميل مطلوب لاستخدام محفظة فلوسك.",
  "errors": {
    "phone": [
      "Customer phone is required."
    ]
  }
}
```

Order already paid:

```json
{
  "status": false,
  "message": "تم دفع هذا الطلب مسبقاً."
}
```

Wrong payment method:

```json
{
  "status": false,
  "message": "طريقة دفع الطلب ليست محفظة فلوسك.",
  "errors": {
    "payment_method": [
      "The order payment method must be floosak_wallet."
    ]
  }
}
```

Invalid OTP request:

```json
{
  "status": false,
  "message": "Validation Error.",
  "errors": {
    "otp": [
      "The otp field is required."
    ]
  }
}
```

## 10. QA Checklist

Mobile QA should verify:

- Floosak appears only when returned by `/api/v1/payment-methods`.
- Order can be created with `payment_method = floosak_wallet`.
- Initiate returns a `payment_attempt_id`.
- OTP screen appears when `requires_otp = true`.
- Sandbox OTP `123456` confirms payment.
- Completed payment navigates to success screen.
- Order is not shown as paid until backend returns `status = completed`.
- Retrying initiate after timeout does not create a duplicate charge.
- Confirm timeout leads to polling, not repeated uncontrolled OTP submissions.
- Missing user phone shows a clear error.
- Mobile logs do not contain OTP values.
