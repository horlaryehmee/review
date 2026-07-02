# LottieFiles WordPress Plugin

A WordPress plugin that allows you to add and customize Lottie animations in your WordPress site using the Gutenberg
editor.

## Prerequisites

### GitHub Access Token

- Create your personal access token on GitHub by
  [following this link](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token).
- Copy `//npm.pkg.github.com/:_authToken=<YOUR-TOKEN>` and paste this line to your `.npmrc` file.
- Replace `<YOUR-TOKEN>` with the access token you just generated on GitHub.

### Local WordPress Environment

- Download and install Local by Flywheel from [localwp.com](https://localwp.com).
- Follow the setup process shown in the images to create a new WordPress site:

  1. Create an account in Local
     <img width="1312" alt="Captura de pantalla 2025-04-22 a la(s) 3 12 25 p m" src="https://github.com/user-attachments/assets/38b6a8a0-52cf-438a-9091-8552b54beda2" />

  2. Set up your WordPress environment
     <img width="1312" alt="Captura de pantalla 2025-04-22 a la(s) 3 12 32 p m" src="https://github.com/user-attachments/assets/648eee35-1174-4e4e-8977-8ffbe2e0ebd3" />

  3. Configure your WordPress credentials
     <img width="1312" alt="Captura de pantalla 2025-04-22 a la(s) 3 12 52 p m" src="https://github.com/user-attachments/assets/7599b834-13a5-42a1-914d-b184f7deb927" />

## Installation

```bash
# Navigate to your WordPress plugins directory
cd ~/Local\ Sites/lottiefiles/app/public/wp-content/plugins/

# Clone the repository
git clone https://github.com/LottieFiles/plugin-wordpress.git lottiefiles

# Navigate to the plugin directory
cd lottiefiles

# Install dependencies
pnpm install
```

## Usage

### Development Mode

```bash
# Start the development server
pnpm start
```

This command runs the block and watches for any changes. Once changes are saved, they will be reflected in the block.

### Building the Plugin

```bash
# Create a build of the plugin
pnpm build

# Create a complete build including Babel transpilation
pnpm build:all
```

## Configuration

The plugin uses environment variables for configuration. Copy the `.env.defaults` file to `.env` for development values
and `.env.production` for production values.

## Testing Builds

1. After building the plugin, activate it in your WordPress admin dashboard.
2. Create a new post or page and look for the LottieFiles block in the Gutenberg editor.
3. Add and customize a Lottie animation to test functionality.

## Debugging

- Use WordPress debug mode by setting `WP_DEBUG` to `true` in your `wp-config.php` file.
- For JavaScript debugging, use your browser's developer tools.

## Scripts

- `pnpm start`: Start development server and watch for changes
- `pnpm build`: Build the plugin for production
- `pnpm build:all`: Build both the main plugin and Babel transpiled code
- `pnpm dev`: Run both start and watch:babel concurrently
- `pnpm lint`: Run ESLint to check code quality
- `pnpm format`: Format code using Prettier
- `pnpm plugin-zip`: Create a distributable plugin zip file

## Troubleshooting

### Common Issues

- **Plugin not appearing in WordPress**: Make sure the plugin is activated in the WordPress admin dashboard.
- **Build errors**: Ensure you have the correct Node.js version installed and all dependencies are properly installed.
- **Authentication errors**: Verify your GitHub token is correctly set in the `.npmrc` file.

## Distribution

### Building

#### Internal Build

For internal testing and QA:

```bash
pnpm build:all
```

#### Production Build

For creating a production-ready build:

```bash
# Create a production build
pnpm build:all

# Create a distributable zip file
pnpm plugin-zip
```

### Publishing

All WordPress.org plugin releases must be done via SVN (https://plugins.svn.wordpress.org/lottiefiles).

#### SVN Basics

- The latest release lives in the `trunk` folder
- Previous releases are stored in the `tags` folder
- Always include the build folder when committing to SVN (with proper .env configuration)

#### Initial SVN Setup

```bash
# Create a directory for the SVN repo (outside your GitHub repo)
mkdir local-plugin-repo

# Install SVN if needed
brew install svn

# Check out the SVN repository (initializes assets, tags, trunk)
svn co https://plugins.svn.wordpress.org/lottiefiles local-plugin-repo
```

#### Creating a New Release

1. Update version numbers in `host.php` and `readme.txt`

2. Build the plugin:

   ```bash
   pnpm install && pnpm build && pnpm plugin-zip
   ```

3. Copy files to SVN trunk:
   - Copy the relevant build and src files from your GitHub repo to your local SVN trunk
   - Be careful not to include `.env` or any sensitive information
   - If you prefer to use SmartSVN you can follow the UI to commit and push the added trunk, to connect to
     https://plugins.svn.wordpress.org/lottiefiles please request access to the lastpass Vault

<img width="1246" alt="Captura de pantalla 2025-04-22 a la(s) 4 49 12 p m" src="https://github.com/user-attachments/assets/5ad63dba-cb60-4b34-8e12-8d96b4c64d05" />

4. Add new files to SVN:

   ```bash
   svn add trunk/*
   ```

5. Create a new version tag:

   ```bash
   svn cp trunk/* tags/x.x.x
   ```

6. Commit changes to SVN:

   ```bash
   svn ci -m "Release version x.x.x" --username lottiefile
   ```

   (Password is stored in LastPass under wordpress.org)

7. Verify the release on the WordPress.org plugin repository
