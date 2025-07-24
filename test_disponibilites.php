<?php

// Test simple pour vérifier la logique de formatage des disponibilités

function formatDisponibilite(?string $jour, ?string $heure): ?string
{
    // Si les deux valeurs sont nulles ou vides, retourner null
    if (empty($jour) && empty($heure)) {
        return null;
    }
    
    // Si seulement le jour est renseigné
    if (!empty($jour) && empty($heure)) {
        return $jour;
    }
    
    // Si seulement l'heure est renseignée
    if (empty($jour) && !empty($heure)) {
        return $heure;
    }
    
    // Si les deux sont renseignés, les concaténer
    return $jour . ' ' . $heure;
}

// Tests
echo "Tests de formatage des disponibilités :\n\n";

// Test 1: Jour et heure renseignés
$result1 = formatDisponibilite("Lundi", "08h-11h");
echo "Test 1 - Jour + Heure: " . ($result1 ?? 'null') . "\n";
echo "Attendu: Lundi 08h-11h\n\n";

// Test 2: Seulement le jour
$result2 = formatDisponibilite("Mardi", null);
echo "Test 2 - Seulement jour: " . ($result2 ?? 'null') . "\n";
echo "Attendu: Mardi\n\n";

// Test 3: Seulement l'heure
$result3 = formatDisponibilite(null, "14h-17h");
echo "Test 3 - Seulement heure: " . ($result3 ?? 'null') . "\n";
echo "Attendu: 14h-17h\n\n";

// Test 4: Rien de renseigné
$result4 = formatDisponibilite(null, null);
echo "Test 4 - Rien: " . ($result4 ?? 'null') . "\n";
echo "Attendu: null\n\n";

// Test 5: Chaînes vides
$result5 = formatDisponibilite("", "");
echo "Test 5 - Chaînes vides: " . ($result5 ?? 'null') . "\n";
echo "Attendu: null\n\n";

echo "Tous les tests terminés !\n";
