FROM nginx:stable-alpine

RUN ls
COPY default.conf /etc/nginx/conf.d/default.conf
COPY . /var/www/slim_app
#COPY docker/web/frontend/default.conf /etc/nginx/conf.d/default.conf
