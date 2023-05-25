FROM nginx:latest

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# not sure if needed
#COPY ./app /var/www/html

RUN usermod -u 1000 -g 0 www-data