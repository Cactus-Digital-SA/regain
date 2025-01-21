import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import html from '@rollup/plugin-html';
import { glob } from 'glob';

/**
 * Get Files from a directory
 * @param {string} query
 * @returns array
 */
function GetFilesArray(query) {
    return glob.sync(query);
}
/**
 * Js Files
 */
// Page JS Files
const pageJsFiles = GetFilesArray('resources/assets/js/*.js');

// Processing Vendor JS Files
const vendorJsFiles = GetFilesArray('resources/assets/vendor/js/*.js');

// Processing Libs JS Files
const LibsJsFiles = GetFilesArray('resources/assets/vendor/libs/**/*.js');

/**
 * Scss Files
 */
// Processing Core, Themes & Pages Scss Files
const CoreScssFiles = GetFilesArray('resources/assets/vendor/scss/**/!(_)*.scss');

// Processing Libs Scss & Css Files
const LibsScssFiles = GetFilesArray('resources/assets/vendor/libs/**/!(_)*.scss');
const LibsCssFiles = GetFilesArray('resources/assets/vendor/libs/**/*.css');

// Processing Fonts Scss Files
const FontsScssFiles = GetFilesArray('resources/assets/vendor/fonts/!(_)*.scss');


// Processing Window Assignment for Libs like jKanban, pdfMake
function libsWindowAssignment() {
    return {
        name: 'libsWindowAssignment',

        transform(src, id) {
            if (id.includes('jkanban.js')) {
                return src.replace('this.jKanban', 'window.jKanban');
            } else if (id.includes('vfs_fonts')) {
                return src.replaceAll('this.pdfMake', 'window.pdfMake');
            }
        }
    };
}

export default defineConfig({
    build: {
        chunkSizeWarningLimit: 2500,
        outDir: "public/build",
        emptyOutDir: false,
        rollupOptions: {
            output: [
                {
                    assetFileNames: (assetInfo) => {
                        let extType = assetInfo.name.split('.').at(1);
                        if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                            extType = 'images';
                        }
                        return `assets/${extType}/[name]-[hash][extname]`;
                    },
                    chunkFileNames: 'assets/js/[name]-[hash].js',
                    entryFileNames: 'assets/js/[name]-[hash].js',
                }
            ]
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/assets/css/demo.css',
                'resources/js/app.js',
                'resources/js/custom.js',
                ...pageJsFiles,
                ...vendorJsFiles,
                ...LibsJsFiles,
                ...CoreScssFiles,
                ...LibsScssFiles,
                ...LibsCssFiles,
                ...FontsScssFiles,
                'resources/css/patient-index.css',
                'resources/css/organization-dashboard.css',
                'resources/css/dashboard-common.css',
                'resources/css/practitioner-dashboard.css',
                'resources/css/export-assessment-report.css',
                'resources/css/navbar-front.css',
                'resources/css/front-main.css',
                'resources/css/help-info-pages.css',
                'resources/css/app.scss',
                'resources/css/palette-gradient.scss',
                'resources/css/palette-variables.scss'

            ],
            refresh: true
        }),
        html(),
        libsWindowAssignment()
    ]
});
