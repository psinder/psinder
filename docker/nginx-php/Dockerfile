FROM nginx:1.15-alpine

ARG CONFIG_PATH=nginx.conf
COPY ${CONFIG_PATH} /etc/nginx/conf.d/app.conf.template

CMD envsubst '$$FPM_HOST $$ROOT_DIR' < /etc/nginx/conf.d/app.conf.template > /etc/nginx/conf.d/app.conf && nginx -g 'daemon off;'
