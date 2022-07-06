<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <title></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
    body {
      margin: 0;
      padding: 0;
      width: 100%;
      color: #fff;
      background-color: #0c1417;
      word-spacing: normal;
      font-family: Ubuntu;
    }

    table {
      width: 100%;
      max-width: 35rem;
      margin: 0 auto;
      padding: 2rem;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    p {
      display: block;
      margin: 1rem 0;
    }

    span{
      color: #888;
    }
  </style>
</head>

<body>
  <table>
    <thead>
      <tr>
        <th>
          <img src="{{ asset('assets/images/head_header/logo.png') }}">
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <p>Bonjour,</p>
          <p>Voici un message envoyé depuis {{ config('app.name', 'Prim\'s') }}</p>
        </td>
      </tr>
      <tr>
        <td>
          <hr>
        </td>
      </tr>
      <tr>
        <td>
          <p><span>Expéditeur :</span> {{ $data->civilite }} {{ $data->name }} {{ $data->lastname }}</p>
          <p><span>Adresse :</span> {{ $data->address }} {{ $data->postcode }} {{ $data->city }} </p>
          <p><span>Téléphone :</span> {{ $data->phone }}</p>
          <p><span>Email :</span> {{ $data->email }}</p>
          <p><span>Sujet :</span> {{ $data->topic }}</p>
          @if ($data->topic=="Réclamation" ) 
            <p><span>Produit :</span> {{ $data->product_name }}</p>
            <p><span>Code Barre :</span> {{ $data->barcode }}</p>
            <p><span>Lot :</span> {{ $data->lot }}</p>
            <p><span>Date limite de consommation :</span> {{ $data->limit_date }}</p>
            <p><span>Lieu d'achat :</span> {{ $data->shop }}</p>
            <p><span>Date de consommation :</span> {{ $data->consumption_date }}</p>
          @endif
          <p><span>Message :</span> {{ $data->message }}</p>
        </td>
      </tr>
      <tr>
        <td>
          <hr>
        </td>
      </tr>
      <tr>
        <td>
          <p>L'équipe {{ config('app.name') }}</p>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>