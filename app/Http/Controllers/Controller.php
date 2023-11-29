<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\Owe;
use App\Models\OweBy;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function user()
    {
        $users = User::with('Owe', 'OwedBy')->get();

        // Construire les données pour chaque utilisateur
        $userData = [];

        foreach ($users as $user) {
            $sum = $user->owe->pluck('amount')->all();
            $sum_two = $user->owedBy->pluck('amount')->all();
            $totalOwe = array_sum($sum);
            $totalOwed = array_sum($sum_two);
            $userData[] = [
                'name' => $user->name,
                'owes' => $user->owe->pluck('amount', 'ower'),
                'owed_by' => $user->owedBy->pluck('amount', 'ower_by'),
                'balance' => $totalOwe - $totalOwed, // Vous devez calculer cette valeur en fonction de votre logique métier
            ];
        }

        // Conversion du tableau en JSON
        $jsonResponse = json_encode($userData);

        // Retour de la réponse JSON avec le bon type de contenu
        return response($jsonResponse, 200)->header('Content-Type', 'application/json');
    }
    public function findUser($name)
    {
        // Récupérer l'utilisateur "Adam" par exemple avec ses relations
        $user = User::where('name', $name)->with('Owe', 'OwedBy')->first();

        $sum = $user->owe->pluck('amount')->all();
        $sum_two = $user->owedBy->pluck('amount')->all();
        $totalOwe = array_sum($sum);
        $totalOwed = array_sum($sum_two);
        // Construire les données à partir des relations
        $data = [
            'name' => $user->name,
            'owes' => $user->owe->pluck('amount', 'ower'),
            'owed_by' => $user->owedBy->pluck('amount', 'ower_by'),
            'balance' => $totalOwe - $totalOwed, // Vous devez calculer cette valeur en fonction de votre logique métier
        ];

        // Conversion du tableau en JSON
        $jsonResponse = json_encode($data);

        // Retour de la réponse JSON avec le bon type de contenu
        return response($jsonResponse, 200)->header('Content-Type', 'application/json');
    }
    public function create (Request $request){
        $request->validate([
            'name'=>'required:unique'
        ]);
        $user= User::create([
            'name'=>$request['name']
        ]);
        $owe = Owe::create([
            'user_id'=>$user->id,
            'ower'=>$request['ower'],
            'amount'=>$request['amount']
        ]);
        $owe = OweBy::create([
            'user_id'=>$user->id,
            'ower_by'=>$request['ower'],
            'amount'=>$request['amount']
        ]);

        $sum = $user->owe->pluck('amount')->all();
        $sum_two = $user->owedBy->pluck('amount')->all();
        $totalOwe = array_sum($sum);
        $totalOwed = array_sum($sum_two);
        $data = [
            'name' => $user->name,
            'owes' => $user->owe->pluck('amount', 'ower'),
            'owed_by' => $user->owedBy->pluck('amount', 'ower_by'),
            'balance' => $totalOwe - $totalOwed, // Vous devez calculer cette valeur en fonction de votre logique métier
        ];

        // Conversion du tableau en JSON
        $jsonResponse = json_encode($data);

        // Retour de la réponse JSON avec le bon type de contenu
        return response($jsonResponse, 200)->header('Content-Type', 'application/json');

    }
}

