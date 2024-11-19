<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DECLARAÇÃO</title>
    <link rel="stylesheet" href="styles.css">
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
            <p>Concluiu nesta Escola, no ano lectivo <strong> @php $anoLetivo=$statement->student->academic_year; $anoLetivo=$anoLetivo+1; @endphp {{$statement->student->academic_year}}/{{$anoLetivo}} </strong>, a <strong style="color: red;" >{{$statement->student->classroom->classes->class_name}},</strong> {{$documentSetting->status_school}} com o resultado final: <strong style="color: red;">{{$statement->gradeStatus}}</strong>  nº da Pauta 01, arquivada nesta Escola, com as seguintes classificações:</p>
        </div>

        <table class="grades" style="margin-bottom: 0px;">

            <tr>
                <th>Disciplina</th>
                <th style="text-align: right; border-top: 1px solid #000; border-right:none; border-bottom: none; border-left: 1px solid #000;">Nota/Extenso</th>
                <th style="border-top: 1px solid #000; border-right:1px solid #000; border-bottom: none; border-left: none;"></th>
            </tr>
            @foreach ($averages as $grade)
            <tr>
                <td>{{mb_convert_case($grade->subjects->subject_name, MB_CASE_TITLE, 'UTF-8')}}</td>
                <td>{{round($grade->average_grade,0)}}</td>
                <td>{{mb_convert_case(\App\Traits\SessionTrait::extensions(round($grade->average_grade,0)), MB_CASE_TITLE, 'UTF-8')}}</td>
            </tr>
            @endforeach
        </table>
        <p style="margin-top: 0px;">Por ser verdade e me ter sido solicitada, mandei passar a presente Declaração que vai por mim assinada e autenticada com carimbo a óleo em uso neste estabelecimento de Ensino.</p>
        <p style="margin-top: 0px;">Escola do {{$documentSetting->status_school}}-{{$documentSetting->number_school}} {{$documentSetting->school_name}} – {{$documentSetting->district}}.</p>
        <div class="signatures">
            <div class="signature">
                <p>Luanda aos {{\App\Traits\SessionTrait::months($statement->date)}}</p>
                <p>O Director da Escola</p>
                <p>__________________________</p>
                <p><strong>{{strtoupper($documentSetting->name_director)}}</strong></p>
            </div>
        </div>
    </div>
    <style>
        body {
            font-family:'Times New Roman', Times, serif;
            display: flex;
            justify-content: center;
            align-items: center;
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
    </style>
</body>
</html>
