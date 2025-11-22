#!/bin/bash
# Complete Ubuntu 24.04 LTS Development Environment Setup
# This script installs Omakub + all your Laravel development tools
# Including PHP 8.1, 8.2, 8.3, and 8.4 with all extensions

set -e

echo "=========================================="
echo "Complete Ubuntu 24.04 Development Setup"
echo "=========================================="
echo ""
echo "This will install:"
echo "1. Omakub (Desktop environment + base dev tools)"
echo "2. PHP 8.1, 8.2, 8.3, and 8.4 with extensions"
echo "3. Composer, Node.js, MySQL, PostgreSQL, Apache"
echo "4. Docker, Redis, VS Code"
echo ""
read -p "Press Enter to continue or Ctrl+C to cancel..."

# ==========================================
# STEP 1: Install Omakub
# ==========================================
echo ""
echo "=========================================="
echo "[STEP 1/2] Installing Omakub..."
echo "=========================================="
echo ""

if command -v omakub &> /dev/null; then
    echo "Omakub is already installed. Skipping..."
else
    echo "Downloading and installing Omakub..."
    wget -qO- https://omakub.org/install | bash

    echo ""
    echo "=========================================="
    echo "Omakub installation complete!"
    echo "=========================================="
    echo ""
    echo "IMPORTANT: You need to REBOOT before continuing."
    echo "After reboot, run this script again to install Laravel tools."
    echo ""
    read -p "Reboot now? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        sudo reboot
    else
        echo "Please reboot manually and run this script again."
        exit 0
    fi
fi

# ==========================================
# STEP 2: Install Laravel Development Tools
# ==========================================
echo ""
echo "=========================================="
echo "[STEP 2/2] Installing Laravel Dev Tools..."
echo "=========================================="
echo ""

# Update system
echo "[1/11] Updating system packages..."
sudo apt update && sudo apt upgrade -y

# Install essential build tools (in case Omakub didn't include them)
echo "[2/11] Installing build essentials and basic tools..."
sudo apt install -y \
    build-essential \
    git \
    curl \
    wget \
    software-properties-common \
    ca-certificates \
    apt-transport-https \
    gnupg \
    lsb-release

# Add Ondrej's PPA for multiple PHP versions
echo "[3/11] Adding PHP repository..."
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.1 and extensions
echo "[4/11] Installing PHP 8.1 and extensions..."
sudo apt install -y \
    php8.1 \
    php8.1-cli \
    php8.1-common \
    php8.1-bcmath \
    php8.1-curl \
    php8.1-gd \
    php8.1-gmp \
    php8.1-intl \
    php8.1-mbstring \
    php8.1-mysql \
    php8.1-pgsql \
    php8.1-xml \
    php8.1-zip \
    php8.1-dom \
    php8.1-ftp \
    php8.1-opcache \
    php8.1-readline \
    php8.1-soap \
    php8.1-xsl

# Install PHP 8.2 and extensions
echo "[5/11] Installing PHP 8.2 and extensions..."
sudo apt install -y \
    php8.2 \
    php8.2-cli \
    php8.2-common \
    php8.2-bcmath \
    php8.2-curl \
    php8.2-gd \
    php8.2-gmp \
    php8.2-intl \
    php8.2-mbstring \
    php8.2-mysql \
    php8.2-pgsql \
    php8.2-xml \
    php8.2-zip \
    php8.2-dom \
    php8.2-ftp \
    php8.2-opcache \
    php8.2-readline \
    php8.2-soap \
    php8.2-xsl

# Install PHP 8.3 and extensions
echo "[6/11] Installing PHP 8.3 and extensions..."
sudo apt install -y \
    php8.3 \
    php8.3-cli \
    php8.3-common \
    php8.3-bcmath \
    php8.3-curl \
    php8.3-gd \
    php8.3-gmp \
    php8.3-intl \
    php8.3-mbstring \
    php8.3-mysql \
    php8.3-pgsql \
    php8.3-xml \
    php8.3-zip \
    php8.3-dom \
    php8.3-ftp \
    php8.3-opcache \
    php8.3-readline \
    php8.3-soap \
    php8.3-xsl \
    php8.3-igbinary \
    php8.3-sqlite3

# Install PHP 8.4 and extensions
echo "[7/11] Installing PHP 8.4 and extensions..."
sudo apt install -y \
    php8.4 \
    php8.4-cli \
    php8.4-common \
    php8.4-bcmath \
    php8.4-curl \
    php8.4-gd \
    php8.4-gmp \
    php8.4-intl \
    php8.4-mbstring \
    php8.4-mysql \
    php8.4-pgsql \
    php8.4-xml \
    php8.4-zip \
    php8.4-dom \
    php8.4-ftp \
    php8.4-opcache \
    php8.4-readline \
    php8.4-soap \
    php8.4-xsl \
    php8.4-igbinary \
    php8.4-sqlite3 \
    php8.4-apcu \
    php8.4-redis

# Set PHP 8.2 as default
echo "Setting PHP 8.2 as default..."
sudo update-alternatives --set php /usr/bin/php8.2
sudo update-alternatives --set phar /usr/bin/phar8.2
sudo update-alternatives --set phar.phar /usr/bin/phar.phar8.2

# Verify PHP installation
php --version

# Install PHP extensions (common across versions)
echo "Installing additional PHP extensions..."
sudo apt install -y \
    php-apcu \
    php-redis

# Install Composer
echo "[8/11] Installing Composer..."
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
composer --version

# Install Node.js and npm (if not installed by Omakub)
echo "[9/11] Installing/Updating Node.js 24.x and npm..."
if ! command -v node &> /dev/null || [[ $(node --version | cut -d'v' -f2 | cut -d'.' -f1) -lt 24 ]]; then
    curl -fsSL https://deb.nodesource.com/setup_24.x | sudo -E bash -
    sudo apt install -y nodejs
fi
node --version
npm --version

# Install MySQL
echo "[10/11] Installing MySQL 8.0..."
if ! command -v mysql &> /dev/null; then
    sudo apt install -y mysql-server mysql-client
    sudo systemctl enable mysql
    sudo systemctl start mysql
fi
mysql --version

# Install PostgreSQL
echo "[11/11] Installing PostgreSQL 16..."
if ! command -v psql &> /dev/null; then
    sudo apt install -y postgresql postgresql-contrib
    sudo systemctl enable postgresql
    sudo systemctl start postgresql
fi
psql --version

# Install Apache
echo "Installing Apache 2.4..."
if ! command -v apache2 &> /dev/null; then
    sudo apt install -y apache2 libapache2-mod-php8.2
    sudo systemctl enable apache2
    sudo systemctl start apache2

    # Enable Apache modules for Laravel
    sudo a2enmod rewrite
    sudo a2enmod headers
    sudo systemctl restart apache2
fi
apache2 -v

# Install Apache PHP modules for all versions
echo "Installing Apache PHP modules for all versions..."
sudo apt install -y \
    libapache2-mod-php8.1 \
    libapache2-mod-php8.2 \
    libapache2-mod-php8.3 \
    libapache2-mod-php8.4

# Install Redis
echo "Installing Redis..."
if ! command -v redis-cli &> /dev/null; then
    sudo apt install -y redis-server
    sudo systemctl enable redis-server
    sudo systemctl start redis-server
fi
redis-cli --version

# Install Docker (if not installed by Omakub)
echo "Installing Docker..."
if ! command -v docker &> /dev/null; then
    # Add Docker's official GPG key
    sudo install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    sudo chmod a+r /etc/apt/keyrings/docker.gpg

    # Add Docker repository
    echo \
      "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
      $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
      sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    # Install Docker
    sudo apt update
    sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

    # Add current user to docker group
    sudo usermod -aG docker $USER
fi
docker --version

# Install VS Code (if not installed by Omakub)
echo "Installing Visual Studio Code..."
if ! command -v code &> /dev/null; then
    wget -qO- https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > packages.microsoft.gpg
    sudo install -D -o root -g root -m 644 packages.microsoft.gpg /etc/apt/keyrings/packages.microsoft.gpg
    echo "deb [arch=amd64,arm64,armhf signed-by=/etc/apt/keyrings/packages.microsoft.gpg] https://packages.microsoft.com/repos/code stable main" | sudo tee /etc/apt/sources.list.d/vscode.list > /dev/null
    rm -f packages.microsoft.gpg
    sudo apt update
    sudo apt install -y code
fi

echo ""
echo "=========================================="
echo "Installation Complete!"
echo "=========================================="
echo ""
echo "Installed PHP versions and tools:"
echo "- PHP 8.1: $(php8.1 --version | head -n 1)"
echo "- PHP 8.2: $(php8.2 --version | head -n 1) [DEFAULT]"
echo "- PHP 8.3: $(php8.3 --version | head -n 1)"
echo "- PHP 8.4: $(php8.4 --version | head -n 1)"
echo ""
echo "Other tools:"
echo "- Composer: $(composer --version | head -n 1)"
echo "- Node.js: $(node --version)"
echo "- npm: $(npm --version)"
echo "- MySQL: $(mysql --version)"
echo "- PostgreSQL: $(psql --version)"
echo "- Apache: $(apache2 -v | head -n 1)"
echo "- Redis: $(redis-cli --version)"
echo "- Docker: $(docker --version)"
echo ""
echo "To switch between PHP versions, use:"
echo "  sudo update-alternatives --config php"
echo ""
echo "Or set specific version:"
echo "  sudo update-alternatives --set php /usr/bin/php8.1"
echo "  sudo update-alternatives --set php /usr/bin/php8.2"
echo "  sudo update-alternatives --set php /usr/bin/php8.3"
echo "  sudo update-alternatives --set php /usr/bin/php8.4"
echo ""
echo "Important next steps:"
echo "1. Reboot your system or run: newgrp docker"
echo "2. Configure MySQL: sudo mysql_secure_installation"
echo "3. Set up PostgreSQL user if needed"
echo "4. Configure Apache virtual hosts for your projects"
echo "5. Set proper permissions for web directories"
echo ""
echo "For Laravel development, install Laravel installer:"
echo "  composer global require laravel/installer"
echo ""
echo "Add Composer global bin to PATH (add to ~/.bashrc or ~/.zshrc):"
echo "  export PATH=\"\$HOME/.config/composer/vendor/bin:\$PATH\""
echo ""
