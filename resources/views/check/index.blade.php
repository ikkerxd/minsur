<h1>Validar excel</h1>

<h4>RUC</h4>
<form method="post" action="{{url('val-company')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="excel">
        <br><br>
        <input type="submit" value="Enviar" style="padding: 10px 20px;">
    </form>


<h4>CLIENTE</h4>
<form method="post" action="{{url('val-participant')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="excel">
        <br><br>
        <input type="submit" value="Enviar" style="padding: 10px 20px;">
    </form>