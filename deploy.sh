#!/bin/bash

echo "working in deploy.sh inside project"
# Set the image name
IMAGE_NAME="khaledtarek54/content-scheduler:latest"

# Pull the latest image from Docker Hub
echo "Pulling the latest image from Docker Hub..."
docker pull $IMAGE_NAME

# Remove old images (optional)
echo "Removing old images..."
docker images -q --filter "dangling=true" | xargs -r docker rmi

# Stop and remove the old container (if any)
echo "Stopping and removing the old container..."
docker-compose -f docker-compose.deploy.yml down

# Ensure dependencies are installed and assets are built
echo "Installing Composer dependencies and building assets..."

# Run composer install in the app container
docker-compose -f docker-compose.deploy.yml run --rm app composer install --no-interaction --prefer-dist --optimize-autoloader

# Run npm install and npm run build for frontend assets
docker-compose -f docker-compose.deploy.yml run --rm app npm install
docker-compose -f docker-compose.deploy.yml run --rm app npm run build --no-warnings

# Run the containers again
echo "Running the new containers..."
docker-compose -f docker-compose.deploy.yml up -d

echo "Deployment complete!"
