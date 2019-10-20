<?php
welcome();
$configuration = setConfiguration();
$password = $configuration['password'];
$gift = $configuration['gift'];
$operations = $configuration['operations'];
$operations = putPasswordInOperationsArray($password, $operations);
cleanScreen();
startGame($gift);
play($operations);

function welcome():void
{
    echo "Jeu sur terminal. Pas de distraction, pas de superflu.\n
    Le principe est simple: \n
    -L'enfant doit trouver un mot de passe en résolvant des additions. Il vous communiquera le mot de passe, et gagnera une récompense (bisou, bonbon...)\n
    -rentrez une récompense, choisissez un mot de passe (1 caractère par opération), et les nombres à additionner.\n
    \n\n\n\n";
}

function setConfiguration():array
{
    $gift = readline('Choisir la récompense. exemple : "un bonbon" ; puis appuyer sur entrée : ');
    $password = readline('Saisir le mot de passe (un caractère = une opération à réaliser) : ');
    $operations = addQuestions(strlen($password));
    return ['gift'=> $gift,'password'=>$password, 'operations'=> $operations];
}

function addNumber($numberOrder)
{
    $number = readline("Saisissez le $numberOrder nombre à additionner : ");
    return $number;    
}

function addQuestions(int $numberOfQuestions):array
{
    $generateAutomaticsOperations = readline("pour générer automatiquement les opérations, tapez 'y' et validez. Pour les rentrer manuellement, tapez 'n' : ");

    if ($generateAutomaticsOperations === 'y'){
        $lowestInterval = readline('saisissez le nombre le plus bas auquel l\'enfant pourra être confronté : ');
        $highestInterval = readline('saisissez le nombre le plus haut auquel l\'enfant pourra être confronté : ');
        return generateAutomaticallyOperations($numberOfQuestions, $lowestInterval, $highestInterval);
    }
    $questions = [];
    for ($i =1 ; $i <= $numberOfQuestions; $i++){
        echo "\n Opération n° ". $i . " : \n";
        $questions[$i]['first number'] = addNumber('premier');
        $questions[$i]['second number']= addNumber('second');
    }
    return $questions;
}

function generateAutomaticallyOperations(int $numberOfQuestions, int $lowestInterval, int $highestInterval):array
{
    $questions = [];
    for ($i =1 ; $i <= $numberOfQuestions; $i++){
        $questions[$i]['first number'] = rand($lowestInterval, $highestInterval);
        $questions[$i]['second number']= rand($lowestInterval, $highestInterval);
    }
    return $questions;
}

function askQuestion ($number, $secondNumber, $letter, $word)
{
    $result = $number + $secondNumber;
    $resultProposed = displayAddition($number, $secondNumber);
    while ($resultProposed != $result){
        echo "Non ! Concentre toi ! \n";
        $resultProposed = displayAddition($number, $secondNumber);
    }
    echo "\n Super ! voici une lettre du mot de passe : " . $letter." \n";
    $word .= $letter;
    
    return $word;
}

function displayAddition($number, $secondNumber)
{
    return readline("\n" . $number .' + ' . $secondNumber . ' = ');
}

function cleanScreen()
{
    for ($i = 0 ; $i<100; $i++)
    {
        echo " \n";
    }
}

function win($word)
{
    echo "\n Bravo tu as gagné ! le mot de passe est : $word \n";
}

function startGame($gift)
{
    echo "Attention ! Le jeu va commencer ! \n Tu dois trouver un mot. \n 
    Ecris la solution de chaque addition, et appuie sur la touche Entrée.\n 
    A chaque fois que tu réussis à trouver le bon résultat de l'addition, je te donne une lettre. \n
    Quand tu as le mot de passe, viens me le dire, et tu gagne $gift ! \n C'est parti ! \n";
}

function putPasswordInOperationsArray($password, $operations)
{    
    $passwordArray = str_split($password);
 
    foreach ($operations as $key => $operation)
    {
        $operations[$key]['letter'] = $passwordArray[$key-1];
    }
    return $operations;
}

function launchOperations($operations)
{
    $word = '';
    foreach ($operations as $key => $operation){
        if ($key > 2)
        { echo " pour l'instant, le mot de passe est : ". $word ."\n" ;
        }
        $word = askQuestion($operation['first number'], $operation['second number'], $operation['letter'], $word);
    }
    return $word;
}

function play($operations)
{
    $word = launchOperations($operations);
    win($word);
}
