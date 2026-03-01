<?php
/**
 * Health Metrics Calculator
 *
 * Provides BMR, TDEE, daily calorie target, water intake,
 * and macronutrient distribution based on user biometrics.
 *
 * BMR formula:  Mifflin-St Jeor (most accurate for general population)
 *   Men:   BMR = 10×weight(kg) + 6.25×height(cm) − 5×age + 5
 *   Women: BMR = 10×weight(kg) + 6.25×height(cm) − 5×age − 161
 *
 * TDEE = BMR × activity multiplier
 * Macro splits vary by goal for optimised results.
 */

/**
 * Calculate all health metrics.
 *
 * @param  int    $age      Years
 * @param  string $gender   "Male" | "Female"
 * @param  float  $height   cm
 * @param  float  $weight   kg
 * @param  string $activity "Sedentary" | "Moderate" | "Active"
 * @param  string $goal     "Fat Loss" | "Muscle Gain" | "Maintenance"
 *
 * @return array  Keys: bmi, bmr, tdee, daily_calorie_target,
 *                      daily_water_liters, protein_g, carbs_g, fats_g
 */
function calculate_health_metrics(
    int    $age,
    string $gender,
    float  $height,
    float  $weight,
    string $activity,
    string $goal
): array {

    // ── BMI ────────────────────────────────────────────────────────────────
    $height_m = $height / 100;
    $bmi = round($weight / ($height_m * $height_m), 2);

    // ── BMR (Mifflin-St Jeor) ───────────────────────────────────────────────
    $bmr_base = (10 * $weight) + (6.25 * $height) - (5 * $age);
    $bmr = ($gender === 'Female')
        ? round($bmr_base - 161, 2)   // Women
        : round($bmr_base + 5,   2);  // Men

    // ── TDEE (Total Daily Energy Expenditure) ──────────────────────────────
    $activity_factors = [
        'Sedentary' => 1.2,    // Little/no exercise
        'Moderate'  => 1.55,   // 3-5 days/week moderate exercise
        'Active'    => 1.725,  // 6-7 days/week hard exercise
    ];
    $factor = $activity_factors[$activity] ?? 1.2;
    $tdee   = round($bmr * $factor, 2);

    // ── Daily Calorie Target ────────────────────────────────────────────────
    $calorie_adjustments = [
        'Fat Loss'    => -500,   // Caloric deficit
        'Muscle Gain' =>  300,   // Caloric surplus
        'Maintenance' =>    0,   // Maintain weight
    ];
    $adjustment            = $calorie_adjustments[$goal] ?? 0;
    $daily_calorie_target  = round($tdee + $adjustment, 2);

    // ── Daily Water Intake ──────────────────────────────────────────────────
    // Base: 33 ml per kg bodyweight
    // Add 350 ml per each workout session for Active, 175 ml for Moderate
    $water_ml = $weight * 33;
    if ($activity === 'Active')   $water_ml += 350;
    if ($activity === 'Moderate') $water_ml += 175;
    $daily_water_liters = round($water_ml / 1000, 2);

    // ── Macronutrient Split ─────────────────────────────────────────────────
    // Splits are tailored per goal:
    //   Fat Loss    → higher protein to preserve muscle, moderate fat, lower carbs
    //   Muscle Gain → higher carbs for energy/glycogen, high protein, moderate fat
    //   Maintenance → balanced distribution
    //
    //          Goal          Protein%  Carbs%  Fats%
    //   Fat Loss               35       30      35
    //   Muscle Gain            30       45      25
    //   Maintenance            30       40      30
    //
    // Calorie density: Protein = 4 kcal/g, Carbs = 4 kcal/g, Fats = 9 kcal/g

    $macro_splits = [
        'Fat Loss'    => ['protein' => 0.35, 'carbs' => 0.30, 'fats' => 0.35],
        'Muscle Gain' => ['protein' => 0.30, 'carbs' => 0.45, 'fats' => 0.25],
        'Maintenance' => ['protein' => 0.30, 'carbs' => 0.40, 'fats' => 0.30],
    ];
    $split = $macro_splits[$goal] ?? $macro_splits['Maintenance'];

    $protein_g = round(($daily_calorie_target * $split['protein']) / 4, 1);
    $carbs_g   = round(($daily_calorie_target * $split['carbs'])   / 4, 1);
    $fats_g    = round(($daily_calorie_target * $split['fats'])    / 9, 1);

    return [
        'bmi'                  => $bmi,
        'bmr'                  => $bmr,
        'tdee'                 => $tdee,
        'daily_calorie_target' => $daily_calorie_target,
        'daily_water_liters'   => $daily_water_liters,
        'protein_g'            => $protein_g,
        'carbs_g'              => $carbs_g,
        'fats_g'               => $fats_g,
    ];
}
