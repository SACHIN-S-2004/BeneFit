CREATE DATABASE IF NOT EXISTS benefit_db;
USE benefit_db;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS health_inputs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  age INT,
  gender VARCHAR(10),
  height_cm FLOAT NOT NULL,
  weight_kg FLOAT NOT NULL,
  bmi FLOAT,
  bmr FLOAT,
  tdee FLOAT,
  daily_calorie_target FLOAT,
  daily_water_liters FLOAT,
  protein_g FLOAT,
  carbs_g FLOAT,
  fats_g FLOAT,
  activity VARCHAR(20),
  disease VARCHAR(50),
  cholesterol FLOAT,
  bp FLOAT,
  glucose FLOAT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS diet_results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  health_input_id INT NOT NULL,
  goal VARCHAR(20),
  final_diet VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (health_input_id) REFERENCES health_inputs(id) ON DELETE CASCADE
);

CREATE TABLE diet_result_foods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  diet_result_id INT NOT NULL,
  food_id INT NOT NULL,
  meal_type ENUM('breakfast','lunch','dinner','snack') NOT NULL,

  FOREIGN KEY (diet_result_id) REFERENCES diet_results(id) ON DELETE CASCADE
);
