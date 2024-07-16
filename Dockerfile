FROM php:7.4-cli

WORKDIR /app

COPY . /app

ENV MYSQL_HOST=localhost
ENV MYSQL_USERNAME=root
ENV MYSQL_DATABASE=lovepotion_db

CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
