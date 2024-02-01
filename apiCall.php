<?php
/**
 * Author: algugler
 * Date de création: 31.01.2024
 * Description: Classe servant à faire l'appel vers l'API
 **/
class apiCall
{
    /**
     * Requête GET vers l'url spécifiée pour récupérer les informations de l'API
     * @param $apiUrl
     * @return mixed|string
     */
    function get($apiUrl) {
        // Initialise la session curl
        $curl = curl_init($apiUrl);

        // Ajoute les options curl pour la requête GET
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute la requête HTTP et récupère la réponse
         $response = curl_exec($curl);

        // Vérifie si une erreur est survenue
         if (curl_errno($curl)) {
             return 'Curl error: ' . curl_error($curl);
         }

        // Ferme la session curl
         curl_close($curl);

        // Retourne la réponse JSON décodée
        return json_decode($response, true);
     }
}
