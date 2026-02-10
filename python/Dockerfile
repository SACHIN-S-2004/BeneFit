# Python/Flask ML API Service
FROM python:3.11-slim

# Set working directory
WORKDIR /app

# Copy ML files and datasets
COPY ./ml/ /app/ml/
COPY ./datasets/ /app/datasets/

# Install Python dependencies
RUN pip install --no-cache-dir flask scikit-learn pandas numpy

# Expose Flask port
EXPOSE 5000

# Set environment variables
ENV FLASK_APP=ml/flask_api.py
ENV FLASK_ENV=production

# Run Flask application
CMD ["python", "ml/flask_api.py"]
