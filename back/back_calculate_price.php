<?php
function convertToEuros($amount) {
    // Taux fixe de conversion USD → EUR
    $conversionRate = 0.92;

    // Convertir la somme et arrondir à 2 décimales
    return round($amount * $conversionRate, 2);
}

function calculatePrice($distance, $speed): float {
    $baseCost = $distance * 100; // 100 crédits par milliard de km

    // Ajustement en fonction de la vitesse
    $speedPercentage = ($speed / 1.08e9 - 1) * 100;

    return $baseCost + ($baseCost * $speedPercentage / 100);
}