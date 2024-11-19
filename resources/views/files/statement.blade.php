<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DECLARAÇÃO #{{$statement->id}} {{$statement->student->user->first_name}} {{$statement->student->user->last_name}}</title>
    <link rel="stylesheet" href="styles.css">
    <script src="{{asset('photo/doc/qrcode.js')}}"></script>
</head>
<body>
    <div class="declaration">
        <div class="header" >
            <img src="{{url('photo/doc/republica-de-angola.jpg')}}" alt="Logotipo da Instituição" align="center" class="logo" style="padding: 0px; margin: 0px;">
            <h6 class="subtitle" style="margin: 0px;">
                <br>
                REPÚBLICA DE ANGOLA <br>
                GOVERNO DA PROVÍNCIA DE LUANDA <br>
                ADMINISTRAÇÃO MUNICIPAL DE {{strtoupper($documentSetting->county)}} <br> 
                DIRECÇÃO MUNICIPAL DA EDUCAÇÃO
                <br>COLÉGIO @isset($documentSetting->number_school)Nº-{{$documentSetting->number_school}} @endisset {{$documentSetting->school_name}}
            </h6>
            <h6 class="subtitle subline" >DISTRITO URBANO DO {{strtoupper($documentSetting->district)}}</h6>
            <h2 >DECLARAÇÃO</h2>
        </div>
        
        <div class="student-info">
            <p class="indent"><strong class="subline">{{mb_convert_case($documentSetting->name_director, MB_CASE_TITLE, 'UTF-8')}},</strong> Director da Escola do {{$documentSetting->status_school}} - {{$documentSetting->school_name}} – {{$documentSetting->district}}. Declara que: <strong style="color: red;" >{{mb_convert_case($statement->student->user->first_name, MB_CASE_TITLE, 'UTF-8')}} {{mb_convert_case($statement->student->user->last_name, MB_CASE_TITLE, 'UTF-8')}}</strong>, Filha de {{mb_convert_case($statement->student->father, MB_CASE_TITLE, 'UTF-8')}} e de {{mb_convert_case($statement->student->mother, MB_CASE_TITLE, 'UTF-8')}}, Natural de {{mb_convert_case($statement->student->natural, MB_CASE_TITLE, 'UTF-8')}}, Província de {{mb_convert_case($statement->student->province, MB_CASE_TITLE, 'UTF-8')}}, Nascida aos {{\App\Traits\SessionTrait::months($statement->student->date_of_birth)}}, Portadora do B.I. nº {{$statement->student->code}}, emitido aos {{\App\Traits\SessionTrait::months($statement->student->emission_at)}}. </p>
            <p class="indent">Frequenta nesta Escola, no ano lectivo <strong> @php $anoLetivo=$statement->student->academic_year; $anoLetivo=$anoLetivo+1; @endphp {{$statement->student->academic_year}}/{{$anoLetivo}} </strong>, a <strong style="color: red;" >{{$statement->student->classroom->classes->class_name}},</strong> ,{{$documentSetting->status_school}}, <br> Sala nº {{$statement->student->classroom->classroom_location}}, Período da {{mb_convert_case($statement->student->classroom->class_schedule, MB_CASE_TITLE, 'UTF-8')}}.</p>
        </div>

        
        <p class="indent">Por ser verdade e me ter sido solicitada, <strong> Para Efeitos de {{mb_convert_case($statement->title, MB_CASE_TITLE, 'UTF-8')}},</strong> mandei passar a presente Declaração que vai por mim assinada e autenticada com carimbo a óleo em uso neste estabelecimento de Ensino.</p>
        <p>Escola do {{-- Iº Ciclo do Ensino Secundário --}} {{$documentSetting->status_school}}-{{-- 4078 --}} {{$documentSetting->number_school}} {{-- Padre Ernesto Rafael --}} {{$documentSetting->school_name}} – {{-- Cidade do Sequele --}} {{$documentSetting->district}} .</p>
        <div class="signatures">
            <div class="signature">
                <p>Luanda aos {{\App\Traits\SessionTrait::months($statement->date)}}</p>
                <p>O Director da Escola</p>
                <p>__________________________</p>
                <p><strong>{{strtoupper($documentSetting->name_director)}}</strong></p>
            </div>
        </div>
        @if($documentSetting->qr_code==true)
            <div id="qrCanvasContainer">
                <canvas id="qrCanvas" align="right" class="logo"></canvas>
            </div>
        @endif
    </div>
    <script>
        var qrText = "{{$statement->student->user->id}} {{$statement->student->academic_year}}";
        var qr = new QRious({
          element: document.getElementById('qrCanvas'),
          value: qrText,
          size: 80
        });
    </script>
    <style>
        body {
            font-family:'Times New Roman', Times, serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .indent{
            text-indent: 40px; /* Indentação da primeira linha */
            text-align: justify;
        }
       
        .declaration {
            background-color: #fff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header .subtitle {
           padding-left: 220px ;
           padding-right: 220px ;
        }
        
        .header .logo {
            width: 80px;
            height: auto;
            margin: 10px 0;
        }
        
        .header h2 {
            margin: 0;
            font-size: 24px;
            text-decoration: underline;
        }
        .subline{
            text-decoration: underline;
        }
        
        .student-info {
            margin-bottom: 20px;
        }
        
        .grades {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .grades th, .grades td {
            border-top: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            border-left: 1px solid #000; /* Remove a borda esquerda */
            padding: 4px;
            text-align: center;
            
        }

        .grades td {
            text-align: left;
            
        }

        
        .grades th {
            background-color: #f2f2f2;
        }
        
        .signatures {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .signature {
            text-align: center;
            margin: 0 20px;
        }
        
        .date {
            text-align: right;
        }
        #qrCanvasContainer {
            text-align: center; /* Alinha o conteúdo à direita */
        }        
    </style>
    <script>
        print();
    </script>
</body>
</html>
