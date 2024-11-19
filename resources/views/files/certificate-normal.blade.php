<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CERTIFICADO</title>
    <link rel="stylesheet" href="styles.css">
    <script src="{{asset('photo/doc/qrcode.js')}}"></script>
</head>
@php
$media=0;
$MEDIA=0;
$count=0;
@endphp
@foreach ($averages as $rows)
@php
$media = $media = (round(\App\Models\CertificateGrade::where("term","term1")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0)+round(\App\Models\CertificateGrade::where("term","term2")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0)+round(\App\Models\CertificateGrade::where("term","term3")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0))/3;
$MEDIA += $media;
$count++;
@endphp
@endforeach
@php
    $MEDIA = $MEDIA/$count;
@endphp
<body>
    <div class="declaration">
        <div class="header" >
            <img src="{{url('photo/doc/republica-de-angola.jpg')}}" alt="Logotipo da Instituição" class="logo" style="margin: 0px; padding:0px;">
            <h5 class="subtitle" style="margin: 0px; padding:0px;">
                REPÚBLICA DE ANGOLA <br>
                MINISTÉRIO DA EDUCAÇÃO 
            </h5>
            <div class="header-qrcode">
                @isset($certificateNormal->name_director)
                <div class="signatures" align="left">
                    <div class="signature">
                        <p style="margin: 0px; padding:0px;">Visto <br> O Director Municipal </p>
                        <p style="margin: 0px; padding:0px;">__________________________</p>
                        <p style="margin: 0px; padding:0px;">{{$certificateNormal->name_director}}</p>
                    </div>
                </div>
                @endisset
                @if($documentSetting->qr_code==true)
                    <div align="right">
                        <canvas id="qrCanvas"  class="logo"></canvas>
                    </div>
                @endif
            </div>
            <h2 >CERTIFICADO</h2>
        </div>
        
        <div class="student-info">
            <p style="text-align: justify;">
                <strong> a) {{mb_convert_case($documentSetting->name_director, MB_CASE_TITLE, 'UTF-8')}}</strong>, 
                Director do colégio @isset($documentSetting->number_school) nº {{$documentSetting->number_school}} @endisset {{$documentSetting->school_name}}, 
                criado, sob o Decreto Executivo nº <strong>49 /15/</strong> de <strong class="subline">18 de Fevereiro</strong>, 
                certifica que: <strong style="color: red;">{{mb_convert_case($certificateNormal->student->user->first_name, MB_CASE_TITLE, 'UTF-8')}} {{mb_convert_case($certificateNormal->student->user->last_name, MB_CASE_TITLE, 'UTF-8')}} </strong>, 
                Filho de {{mb_convert_case($certificateNormal->student->father, MB_CASE_TITLE, 'UTF-8')}} e de {{mb_convert_case($certificateNormal->student->mother, MB_CASE_TITLE, 'UTF-8')}}, nascido aos  {{\App\Traits\SessionTrait::months($certificateNormal->student->date_of_birth)}}, natural de {{mb_convert_case($certificateNormal->student->natural, MB_CASE_TITLE, 'UTF-8')}}, Município de {{mb_convert_case($certificateNormal->student->natural, MB_CASE_TITLE, 'UTF-8')}}, Província de {{mb_convert_case($certificateNormal->student->province, MB_CASE_TITLE, 'UTF-8')}}, Nacionalidade: Angolana, titular do B.I nº {{$certificateNormal->student->code}}, 
                Passado pelo Arquivo de Identificação Nacional aos {{\App\Traits\SessionTrait::months($certificateNormal->student->emission_at)}}, 
                concluiu no ano lectivo de @php $anoLetivo=$certificateNormal->academic_year; $anoLetivo=$anoLetivo+1; @endphp {{$certificateNormal->student->academic_year}}/{{$anoLetivo}} sob o nº 320  da pauta o <strong>{{mb_convert_case($documentSetting->status_school, MB_CASE_TITLE, 'UTF-8')}} Geral</strong>, conforme o disposto na alínea c) do artigo 109º. Da LBSEE 17/16 de 07 de Outubro, com a Média Final de {{mb_convert_case(\App\Traits\SessionTrait::extensions(round($MEDIA,0)), MB_CASE_TITLE, 'UTF-8')}}  (<strong>{{round($MEDIA)}}</strong>) valores obtida nas seguintes classificações:</p>
        </div>

        <table class="grades" style="margin-bottom: 0px;">

            <tr>
                <th>Disciplina</th>
                @if ($documentSetting->status_school=="I CICLO DO ENSINO SECUNDÁRIO" || $documentSetting->status_school=="I Ciclo do Ensino Secundário"  )
                    <th>7ª Classe</th>
                    <th>8ª Classe</th>
                    <th>9ª Classe</th>    
                @else
                    <th>10ª Classe</th>
                    <th>11ª Classe</th>
                    <th>12ª Classe</th>
                @endif
                <th>Média Final por disciplina</th>
                <th>Média Por Extenso</th>
                
            </tr>
            @php
                $media=0;
            @endphp
            @foreach ($averages as $rows)
            @php $media = (round(\App\Models\CertificateGrade::where("term","term1")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0)+round(\App\Models\CertificateGrade::where("term","term2")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0)+round(\App\Models\CertificateGrade::where("term","term3")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0))/3; @endphp 
            <tr>
                <td>{{$rows->subject->subject_name}}</td>
                <td>@isset(\App\Models\CertificateGrade::where("term","term1")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->first()->id) {{round(\App\Models\CertificateGrade::where("term","term1")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0)}} @endisset</td>
                <td>@isset(\App\Models\CertificateGrade::where("term","term2")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->first()->id) {{round(\App\Models\CertificateGrade::where("term","term2")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0)}} @endisset</td>
                <td>@isset(\App\Models\CertificateGrade::where("term","term3")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->first()->id) {{round(\App\Models\CertificateGrade::where("term","term3")->where("certificate_normal_id",$certificateNormal->id)->where("subject_id",$rows->subject->id)->avg("grade"),0)}} @endisset</td>
                <td>
                    {{round($media,0)}}
                </td>
                <td>{{mb_convert_case(\App\Traits\SessionTrait::extensions(round($media,0)), MB_CASE_TITLE, 'UTF-8')}} Valores</td>
            </tr>
            @endforeach
        </table>
        <p class="indent">Para efeitos legais, lhe é passado o presente <strong>CERTIFICADO</strong>. Que consta no livro de registo nº 10. Folha 01. Assinado por mim e autenticado com carimbo a óleo em uso neste estabelecimento de ensino.</p>
        <p>ESCOLA DO {{strtoupper($documentSetting->status_school)}} №  {{strtoupper($documentSetting->number_school)}}, AOS {{strtoupper(\App\Traits\SessionTrait::months($certificateNormal->date))}}.</p>
        <p>Luanda aos {{\App\Traits\SessionTrait::months($certificateNormal->date)}}</p>
        <div class="signatures">
            <div class="signature">
                <p>Conferido por:</p>
                <p>__________________________</p>
                <p style="color: #979797;">a) Nome do Director</p>
            </div>
            <div class="signature">
                <p>O Director da Escola</p>
                <p>__________________________</p>
                <p><strong>{{strtoupper($documentSetting->name_director)}}</strong></p>
            </div>
            
        </div>
    </div>
    <script>
        var qrText = "{{$certificateNormal->student->user->id}} {{$certificateNormal->student->academic_year}}";
        var qr = new QRious({
          element: document.getElementById('qrCanvas'),
          value: qrText,
          size: 80
        });
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
            padding: 2px;
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
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .signature {
            text-align: center;
            margin: 0 20px;
        }
        
        .date {
            text-align: right;
        }
        .header-qrcode{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }        
    </style>
</body>
</html>
