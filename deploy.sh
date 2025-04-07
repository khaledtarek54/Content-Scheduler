#!/bin/bash

# Set the image name
IMAGE_NAME="khaledtarek54/content-scheduler:latest"

# Pull the latest image from Docker Hub
echo "Pulling the latest image from Docker Hub..."
docker pull $IMAGE_NAME

# Stop and remove the old container (if any)
echo "Stopping and removing the old container..."
docker stop content_scheduler_app
docker rm content_scheduler_app

# Run the new container
echo "Running the new container..."
docker run -d --name content_scheduler_app \
  -p 80:80 \
  --restart unless-stopped \
  $IMAGE_NAME
