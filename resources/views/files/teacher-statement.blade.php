<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DECLARAÇÃO #{{$statementTeacher->id}} {{$statementTeacher->teacher->user->first_name}} {{$statementTeacher->teacher->user->last_name}}</title>
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
            <p><strong class="subline">{{mb_convert_case($documentSetting->name_director, MB_CASE_TITLE, 'UTF-8')}},</strong> Director da Escola do {{$documentSetting->status_school}} - {{$documentSetting->school_name}} – {{$documentSetting->district}}, declara-se que: <span style="color: red;">{{$statementTeacher->teacher->user->first_name}} {{$statementTeacher->teacher->user->last_name}}</span> , Agente Nº {{$statementTeacher->teacher->user->email}}. É funcionária colocada nesta escola, exercendo a função de Professora, auferindo um sálario base de {{number_format($statementTeacher->gross_salary,2,",",".")}}</p>
            <p>Por ser verdade e me ter sido solicitado, mandei passar a presente declaração para <strong>Efeito de {{$statementTeacher->title}}</strong>, que vai por mim assinada e autenticada com o carimbo a óleo em uso nesta instituição de ensino.</p>
        </div>

        
        <div class="signatures">
            <div class="signature">
                <p>Luanda aos {{\App\Traits\SessionTrait::months($statementTeacher->date)}}</p>
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
        var qrText = "{{$statementTeacher->teacher->user->id}} {{$statementTeacher->teacher->academic_year}}";
        var qr = new QRious({
          element: document.getElementById('qrCanvas'),
          value: qrText,
          size: 80
        });
    </script>
    <script>
        print();
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
            text-align: justify;
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
</body>
</html>
