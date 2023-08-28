FROM nginx:latest

# Remove default nginx site
RUN rm -f /etc/nginx/conf.d/*

# Copy our nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf