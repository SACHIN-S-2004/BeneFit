# MySQL Database Service
FROM mysql:8.0

# Set environment variables (can be overridden in docker-compose)
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=benefit_db
ENV MYSQL_USER=benefit_user
ENV MYSQL_PASSWORD=benefit_pass

# Copy database schema
COPY ../database/schema.sql /docker-entrypoint-initdb.d/

# Expose MySQL port
EXPOSE 3306
