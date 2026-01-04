import pandas as pd
import numpy as np
import pickle

from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report


# Load Dataset
df = pd.read_csv("diet_recommendations_dataset.csv")

# ENGINEER GOAL FEATURE
def assign_goal(row):
    if row['BMI'] >= 25:
        return 'Fat Loss'
    elif row['Physical_Activity_Level'] == 'Active':
        return 'Muscle Gain'
    else:
        return 'Maintenance'

df['Goal'] = df.apply(assign_goal, axis=1)
print(df.head())

# Select Features
features = [
    'Age',
    'Gender',
    'BMI',
    'Disease_Type',
    'Physical_Activity_Level',
    'Cholesterol_mg/dL',
    'Blood_Pressure_mmHg',
    'Glucose_mg/dL',
    'Goal'
]

target = 'Diet_Recommendation'

X = df[features]
y = df[target]


# Encode Categorical Data
label_encoders = {}

for col in X.select_dtypes(include='object').columns:
    le = LabelEncoder()
    X[col] = le.fit_transform(X[col])
    label_encoders[col] = le

target_encoder = LabelEncoder()
y = target_encoder.fit_transform(y)

# Split Data
X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42
)

# =========================
model = RandomForestClassifier(
    n_estimators=200,
    max_depth=12,
    random_state=42
)

model.fit(X_train, y_train)

# =========================
y_pred = model.predict(X_test)
print("Accuracy:", accuracy_score(y_test, y_pred))
print(classification_report(y_test, y_pred))


# =========================
with open("diet_model.pkl", "wb") as f:
    pickle.dump(model, f)

with open("label_encoders.pkl", "wb") as f:
    pickle.dump({
        "features": label_encoders,
        "target": target_encoder
    }, f)

print("✅ Model and encoders saved successfully")
