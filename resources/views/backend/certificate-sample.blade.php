<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" >
    <link href="https://fonts.googleapis.com/css2?family=Waterfall&display=swap" rel="stylesheet">
</head>
<body>

    <style >
        body {
            background-image: url("{{ public_path().'/assets/certificateTemplate/certificate-main-sample.png'}}");
            background-repeat: no-repeat;
            background-size: 100% 100% ;
            background-image-resize: 6;
        }
        h1{
            position: absolute;
            left: 500px;
            top: 420px;
            text-align: center;
            font-size: 80px;
            font-family: cursive;
            font-weight: bold;
        }
        .grade-center{
            position: absolute;
            top: 600px;
            left: 500px;
            width:700px;
            text-align: justify;
            text-align-last: center;
            font-size: 20px;
            line-height: 30px;
            font-family: HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Helvetica, Arial, Lucida Grande, serif;
            font-weight: bold;
        }
        .date-section{
            position: absolute;
            top: 840px;
            left: 340px;
            text-align: center;
            font-size: 30px;
        }
    </style>
    <p class="name-center">
        <h1>{{$name}}</h1>
    </p>
    <p class="grade-center">
        Mr./Mrs. {{$name}} son/daughter of Mr. {{$father}} and Mrs. {{$mother}}
        has successfully completed the course from our Institute {{$institute}}.

    </p>
    <p class="date-section">
        {{date('dS F Y')}}
    </p>

</body>
</html>
