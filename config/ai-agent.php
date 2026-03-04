<?php

return [

    'default' => env('AI_AGENT_DRIVER', 'openai'),

    'verify_ssl' => env('AI_AGENT_VERIFY_SSL', true),

    'drivers' => [

        'openai' => [
            'api_key' => env('OPENAI_API_KEY', env('AI_AGENT_API_KEY')),
            'model' => env('OPENAI_MODEL', env('AI_AGENT_MODEL', 'gpt-4o-mini')),
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'timeout' => 60,
            'retry' => [
                'times' => 3,
                'sleep' => 1000,
            ],
        ],

        'anthropic' => [
            'api_key' => env('ANTHROPIC_API_KEY', env('AI_AGENT_API_KEY')),
            'model' => env('ANTHROPIC_MODEL', env('AI_AGENT_MODEL', 'claude-3-5-sonnet-20241022')),
            'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com/v1'),
            'timeout' => 60,
        ],

        'gemini' => [
            'api_key' => env('GEMINI_API_KEY', env('AI_AGENT_API_KEY')),
            'model' => env('GEMINI_MODEL', env('AI_AGENT_MODEL', 'gemini-1.5-flash')),
            'base_url' => 'https://generativelanguage.googleapis.com/v1beta',
            'timeout' => 60,
        ],

        'deepseek' => [
            'api_key' => env('DEEPSEEK_API_KEY', env('AI_AGENT_API_KEY')),
            'model' => env('DEEPSEEK_MODEL', env('AI_AGENT_MODEL', 'gemini-pro')),
            'base_url' => env('DEEPSEEK_BASE_URL', 'https://api.deepseek.com/v1'),
            'timeout' => 60,
            'retry' => [
                'times' => 3,
                'sleep' => 1000,
            ],
        ],

        'openrouter' => [
            'api_key' => env('OPENROUTER_API_KEY', env('AI_AGENT_API_KEY')),
            'model' => env('OPENROUTER_MODEL', env('AI_AGENT_MODEL', 'openai/gpt-4o-mini')),
            'base_url' => env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'),
            'site_url' => env('APP_URL'),
            'site_name' => env('APP_NAME', 'Laravel AI Agent'),
            'timeout' => 60,
            'retry' => [
                'times' => 3,
                'sleep' => 1000,
            ],
        ],

    ],

    'agents' => [
        // \App\AI\Agents\ShopAgent::class,
    ],

    'discovery' => [
        'enabled' => true,
        'paths' => [
            app_path('AI/Tools'),
        ],
        'cache' => env('AI_AGENT_CACHE_TOOLS', false),
        'cache_ttl' => 3600,
    ],

    'memory' => [
        'driver' => env('AI_AGENT_MEMORY', 'database'),
        'summarize_after' => 10,
        'max_messages' => 100,
        'recent_messages' => 4,
        'ai_summarization' => env('AI_AGENT_AI_SUMMARY', false),
    ],

    'rate_limit' => [
        'enabled' => env('AI_AGENT_RATE_LIMIT', true),
        'max_requests_per_minute' => 20,
    ],

    'logging' => [
        'enabled' => env('AI_AGENT_LOGGING', true),
        'channel' => env('AI_AGENT_LOG_CHANNEL', 'stack'),
    ],

    'smart_resolution' => [
        'enabled' => env('AI_AGENT_SMART_RESOLUTION', false),
    ],

    'widget' => [
        'enabled' => env('AI_AGENT_WIDGET_ENABLED', true),
        'prefix' => 'ai-agent',
        'middleware' => ['web'],

        'theme' => 'dark',
        'lang' => 'ar',
        'rtl' => true,
        'primary_color' => '#2d81ff',
        'position' => 'bottom-right',

        'title' => 'مساعد المتجر الذكي',
        'subtitle' => 'متصل الآن',

        'welcome_message' => 'مرحباً بك! أنا مساعدك الذكي، كيف يمكنني مساعدتك في إدارة متجرك اليوم؟',
        'placeholder' => 'اكتب سؤالك هنا...',

        'system_prompt' => 'أنت مساعد شخصي للتاجر الحالي .',
    ],

    'security' => [
        'enabled' => env('AI_AGENT_SECURITY_ENABLED', true),
        'max_tool_calls_per_request' => 10,
        'max_iterations' => 10,
        'max_message_length' => 5000,
        'confirm_destructive' => env('AI_AGENT_CONFIRM_DESTRUCTIVE', true),

        'content_moderation' => [
            'enabled' => true,
            'block_injections' => true,
        ],

        'output_sanitization' => [
            'enabled' => true,
            'prevent_xss' => true,
            'redact_secrets' => true,
        ],

        'prompt_hardening' => [
            'enabled' => true,
        ],

        'audit' => [
            'enabled' => true,
            'channel' => 'stack',
            'log_messages' => false,
        ],
    ],

    'performance' => [
        'loop_delay_ms' => env('AI_AGENT_LOOP_DELAY', 300),
    ],

];