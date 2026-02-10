from flask import Flask, request, jsonify
import pickle
import pandas as pd

app = Flask(__name__)

# =========================
# Load ML model & encoders
# =========================
with open("/app/ml/diet_model.pkl", "rb") as f:
    model = pickle.load(f)

with open("/app/ml/label_encoders.pkl", "rb") as f:
    encoders = pickle.load(f)

feature_encoders = encoders["features"]
target_encoder = encoders["target"]

# =========================
# Load food dataset
# =========================
food_df = pd.read_csv("/app/datasets/daily_food_nutrition_dataset.csv")
food_df.columns = food_df.columns.str.strip()

# =========================
# Safe label encoding
# =========================
def safe_transform(le, value):
    if value not in le.classes_:
        return le.transform([le.classes_[0]])[0]
    return le.transform([value])[0]

# =========================
# Goal inference
# =========================
def infer_goal(bmi, activity):
    if bmi >= 25:
        return "Fat Loss"
    if activity == "Active":
        return "Muscle Gain"
    return "Maintenance"

# =========================
# FINAL DECISION ENGINE
# =========================
def decide_final_diet(goal, disease, ml_diet):
    disease = disease.lower()

    if goal == "Muscle Gain":
        if disease == "diabetes":
            return "High_Protein_Low_Sugar"
        if disease == "hypertension":
            return "High_Protein_Low_Sodium"
        return "High_Protein"

    if goal == "Fat Loss":
        if disease == "diabetes":
            return "Low_Carb_Low_Sugar"
        if disease == "hypertension":
            return "Low_Carb_Low_Sodium"
        return "Low_Carb"

    if goal == "Maintenance":
        if disease == "diabetes":
            return "Low_Sugar"
        if disease == "hypertension":
            return "Low_Sodium"
        return "Balanced"

    return ml_diet

# =========================
# FOOD RECOMMENDATION
# =========================
def recommend_food(final_diet, meal_type):
    df = food_df.copy()

    if "Low_Carb" in final_diet:
        df = df[df["Carbohydrates (g)"] <= 30]

    if "Low_Sugar" in final_diet:
        df = df[df["Sugars (g)"] <= 5]

    if "Low_Sodium" in final_diet:
        df = df[df["Sodium (mg)"] <= 150]

    if "High_Protein" in final_diet:
        df = df[df["Protein (g)"] >= 15]

    df = df[df["Meal_Type"] == meal_type]

    return df[
        ["Food_Item", "Calories (kcal)", "Protein (g)", "Carbohydrates (g)", "Fat (g)"]
    ].head(5).to_dict(orient="records")

# =========================
# API ENDPOINT
# =========================
@app.route("/predict", methods=["POST"])
def predict():
    try:
        data = request.json

        bmi = float(data["BMI"])
        activity = data["Physical_Activity_Level"]
        disease = data["Disease_Type"]

        goal = infer_goal(bmi, activity)

        # Build ML input
        input_df = pd.DataFrame([{
            "Age": data["Age"],
            "Gender": data["Gender"],
            "BMI": bmi,
            "Disease_Type": disease,
            "Physical_Activity_Level": activity,
            "Cholesterol_mg/dL": data["Cholesterol_mg/dL"],
            "Blood_Pressure_mmHg": data["Blood_Pressure_mmHg"],
            "Glucose_mg/dL": data["Glucose_mg/dL"],
            "Goal": goal
        }])

        for col, le in feature_encoders.items():
            input_df[col] = input_df[col].apply(lambda x: safe_transform(le, x))

        ml_pred = model.predict(input_df)[0]
        ml_diet = target_encoder.inverse_transform([ml_pred])[0]

        final_diet = decide_final_diet(goal, disease, ml_diet)

        return jsonify({
            "goal": goal,
            "final_diet": final_diet,
            "breakfast": recommend_food(final_diet, "Breakfast"),
            "lunch": recommend_food(final_diet, "Lunch"),
            "dinner": recommend_food(final_diet, "Dinner")
        })

    except Exception as e:
        return jsonify({"error": str(e)}), 500

# =========================
# RUN
# =========================
if __name__ == "__main__":
    app.run(debug=True)
