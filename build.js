#!/usr/bin/env node

const fs = require('fs');
const path = require('path');

console.log('Building plugin...');

// Create dist directory
const distDir = path.join(__dirname, 'dist');
if (!fs.existsSync(distDir)) {
    fs.mkdirSync(distDir, { recursive: true });
}

// Read source plugin file
const srcPath = path.join(__dirname, 'src', 'plugin.php');
let pluginContent = fs.readFileSync(srcPath, 'utf8');

// Get version from package.json
const packageJson = require('./package.json');
const version = packageJson.version;

// Get build timestamp
const buildTime = new Date().toISOString();

// Replace placeholders with actual values
pluginContent = pluginContent.replace(
    /Version: .+/,
    `Version: ${version}`
);

// Add constants for build info
const constants = `
// Build information
define( 'BUILT_ARTIFACT_DEMO_VERSION', '${version}' );
define( 'BUILT_ARTIFACT_DEMO_BUILD_TIME', '${buildTime}' );

`;

// Insert constants after the opening <?php tag
pluginContent = pluginContent.replace(
    /(if \( ! defined\( 'ABSPATH' \) \) \{[\s\S]+?\})/,
    `$1\n${constants}`
);

// Write to dist directory
const distPath = path.join(distDir, 'plugin.php');
fs.writeFileSync(distPath, pluginContent);

console.log(`Plugin built successfully!`);
console.log(`Output: ${distPath}`);
console.log(`Version: ${version}`);
console.log(`Build time: ${buildTime}`);
