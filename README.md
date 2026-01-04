<div align="center">

# 🥗 BeneFit
### *An AI-Powered Personalized Diet & Fitness Recommendation System*

An intelligent full-stack web application that delivers **safe, goal-oriented diet recommendations** by combining **machine learning** with **medical rule-based decision logic**.

</div>

---

## 🛠 Tech Stack

### Frontend
![PHP](https://img.shields.io/badge/PHP-Server-blue?style=for-the-badge&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?style=for-the-badge&logo=bootstrap)
![HTML5](https://img.shields.io/badge/HTML5-Markup-orange?style=for-the-badge&logo=html5)
![CSS3](https://img.shields.io/badge/CSS3-Styles-blue?style=for-the-badge&logo=css3)

### Backend
![Flask](https://img.shields.io/badge/Flask-Web_App-black?style=for-the-badge&logo=flask)
![Session](https://img.shields.io/badge/Session-Handling-lightgrey?style=for-the-badge&logo=python)

### Machine Learning
![Python](https://img.shields.io/badge/Python-3.9+-blue?style=for-the-badge&logo=python)
![Scikit-Learn](https://img.shields.io/badge/Scikit--Learn-ML-orange?style=for-the-badge&logo=scikit-learn)
![Label Encoding](https://img.shields.io/badge/Label-Encoding-teal?style=for-the-badge&logo=python)
![Classification](https://img.shields.io/badge/Supervised-Classification-red?style=for-the-badge&logo=python)
![Hybrid Rules](https://img.shields.io/badge/Hybrid-Rule_Based-brown?style=for-the-badge&logo=python)

### Database
![MySQL](https://img.shields.io/badge/MySQL-Relational-blue?style=for-the-badge&logo=mysql)
![Schema](https://img.shields.io/badge/Schema-Normalized-darkblue?style=for-the-badge&logo=database)

---


## 🚀 Overview

Generic diet plans fail because every individual has **unique health conditions, goals, and lifestyles**.  
This project solves that problem by building a **hybrid decision system** that intelligently recommends diets based on:

- User goals (Muscle Gain, Fat Loss, Maintenance)
- Medical conditions (Diabetes, Hypertension)
- Lifestyle and biometric data
- Machine learning pattern recognition
- Medically safe rule enforcement

Unlike purely ML-based systems, this application **guarantees biologically consistent and safe outcomes**.

---

## 🧠 Key Features

### 🔐 User Authentication
- Secure user registration and login
- Session-based access control
- Persistent user profiles using MySQL

### 📊 Health Data Collection
- Height & weight based BMI calculation
- Lifestyle inputs (activity level)
- Medical indicators (cholesterol, glucose, BP)
- All inputs stored for history and tracking

### 🤖 Intelligent Decision Engine (Core Highlight)
- **Machine Learning** identifies dietary patterns
- **Rule-Based Logic** enforces medical safety
- Final recommendations never violate health constraints

> ML assists decisions — rules guarantee correctness.

### 🥗 Personalized Diet Output
- Goal-aligned diet types
- Condition-aware constraints
- Meal-wise food recommendations:
  - Breakfast
  - Lunch
  - Dinner

### 📈 User Dashboard
- Summary of latest recommendation
- Recommendation history
- Quick access to generate new plans
- Dark / Light mode UI

---

## 🧩 Decision Logic (Authoritative)

| Goal        | Condition        | Final Diet               |
|-------------|------------------|--------------------------|
| Muscle Gain | None             | High_Protein             |
| Muscle Gain | Diabetes         | High_Protein_Low_Sugar   |
| Muscle Gain | Hypertension     | High_Protein_Low_Sodium  |
| Fat Loss    | None             | Low_Carb                 |
| Fat Loss    | Diabetes         | Low_Carb_Low_Sugar       |
| Fat Loss    | Hypertension     | Low_Carb_Low_Sodium      |
| Maintenance | None             | Balanced                 |
| Maintenance | Diabetes         | Low_Sugar                |
| Maintenance | Hypertension     | Low_Sodium               |

This hierarchy ensures:
1. **Medical safety is never compromised**
2. User goals are respected
3. Recommendations remain explainable and realistic

### Database
- MySQL
- Normalized relational schema

  
---

