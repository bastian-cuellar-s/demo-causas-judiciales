<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    
</head>

    <body>
        <p>Estimado(a).</p>
        <div> Se informa que con fecha de hoy {{$dataEmail['date']}}, se realizo diligencia de {{$dataEmail['encargo']}}, en causa {{$dataEmail['rol']}}, 
        con caratulado {{$dataEmail['caratulado']}} del tribunal {{$dataEmail['tribunal']}}</div><br>
        
        <p>{{$dataEmail['msg']}}</p><br>

        <p>Saluda atentamente,</p><br>
        <p><em>Sara Cuellar Zamora, Receptora judicial</em></p>

    </body>

</html>
