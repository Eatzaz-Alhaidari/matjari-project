import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Cairo', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-blue': {
                    '50': '#E6F0F5', // <-- هذا هو اللون الذي سنستخدمه
                    '100': '#CFE1EA',
                    '200': '#A0C3D6',
                    '300': '#70A5C1',
                    '400': '#4087AD',
                    '500': '#106998',
                    '600': '#0D547A',
                    '700': '#0A3F5B',
                    '800': '#072A3D',
                    '900': '#03151E',
                    DEFAULT: '#015C92',
                },
 'brand-orange': {
                    '50': '#FFF8E1',
                    '100': '#FFE0B2',
                    '200': '#FFCC80',
                    '300': '#FFB74D',
                    '400': '#FFA726',
                    '500': '#FF9800',
                    '600': '#FB8C00',
                    '700': '#F57C00', // <-- سنستخدم هذه الدرجة
                    '800': '#EF6C00',
                    '900': '#E65100',
                    DEFAULT: '#FFA931',
                },
                // ##### بداية الجزء المضاف #####
                'brand-green': {
                    '50': '#E8F5E9',
                    '100': '#C8E6C9',
                    '600': '#43A047',
                    '800': '#2E7D32',
                },
                'brand-purple': {
                    '50': '#F3E5F5',
                    '100': '#E1BEE7',
                    '600': '#8E24AA',
                    '800': '#6A1B9A',
                },
                 'brand-indigo': {
                    '50': '#E8EAF6',
                    '100': '#C5CAE9',
                    '600': '#3949AB',
                    '800': '#283593',
                },
                'brand-yellow': {
                    '50': '#FFFDE7',
                    '100': '#FFF9C4',
                    '500': '#FFEB3B',
                    '800': '#F9A825',
                },
                'brand-rose': {
                    '50': '#FFF1F2',
                    '100': '#FFE4E6',
                    '500': '#F43F5E',
                    '800': '#E11D48',
                },
                'brand-red': {
                    '50': '#FEE2E2',
                    '100': '#FECACA',
                    '600': '#E11D48',
                    '800': '#B91C1C',
                },
                // ##### نهاية الجزء المضاف #####
            }
        },
    },

    plugins: [forms],
};