<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/ccsit-logo.jpg') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/css/print-page.css') }}" media="print">
    <title>
    @if($val == 1)
    IMS {{ $hte->name }} {{ Session::get('year') }}
    @endif
    @if($val == 2)
    IMS Interns {{ Session::get('year') }}
    @endif
    </title>
</head>

<style>
    * {
        font-family: Cambria;
        font-size: 12px;
    }
    button {
        font-family: inherit;
        font-size: 11px;
        background-color: blue;
        color: white;
        padding: 0.8em 1.2em;
        border: none;
        border-radius: 10px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s;
        margin-bottom: 20px;
        cursor: pointer;
    }
    table {
        width: 100%;
        height: auto;
        border: 1px solid lightgray;
        border-collapse: collapse;
    }
    table tr th {
        border: 1px solid lightgray;
        padding: 5px;
    }
    table tr td {
        padding: 10px;
        border: 1px solid lightgray;
    }

    .footer {
        margin-top: 20px;
        width: 100%;
        height: auto;
        border: 1px solid white;
        border-collapse: collapse;
    }
    .footer tr th {
        border: 1px solid white;
        padding: 5px;
    }
    .footer tr td {
        padding: 10px;
        border: 1px solid white;
    }
</style>

<body>
    <div id="print-btn">
        <button onclick="window.location.href='{{ route('host-training-establishments') }}'"><i class="fa-solid fa-left-long"></i> Back</button>
        <button class="btn btn-primary" onclick="window.print();"><i class="fa-solid fa-print"></i> Print | PDF</button>
    </div>

    @if($val == 1)
        <i style="float: right;">Annex "D"</i><br>
        <center>
            <h4>REPORT ON THE LIST HOST TRAINING ESTABLISHMENTS (HTEs) AND STUDENT INTERNS PARTICIPATING IN THE STUDENT <br> INTERNSHIP PROGRAM IN THE PHILIPPINES (SIPP)</h4>
            <h4>AY <span style="text-decoration: underline;">{{ Session::get('year') }}</span></h4>
        </center>

        <h4>HEI: <span style="text-decoration: underline; margin-left: 50px;">SOUTHERN LEYTE STATE UNIVERSIRTY - MAIN</span></h4>
        <H4>ADDRESS: <span style="text-decoration: underline; margin-left: 19px;">SAN ROQUE, SOGOD, SOUTHERN LEYTE, 6606</span></H4>
        <table>
            <tr>
                <th>
                    PARTNER HOST TRAINING <br> ESTABLISHMENTS (HTEs)
                </th>
                <th>
                    NAME OF STUDENT INTERNS
                </th>
                <th>
                    PROGRAM
                </th>
                <th>
                    GENDER
                </th>
                <th>
                    DATES OF DURATION <br> OF THE INTERNSHIP
                </th>
            </tr>
            @php $count = 0; @endphp
            @foreach($interns as $int)
            <tr>
                <th style="text-align: center;"> @if($count == 0) {{ $hte->name }} @endif</th>
                <td style="text-transform: capitalize;">{{ $int->name }}</td>
                <td>BS Info Tech. @if($int->major == "P") Programming @endif @if($int->major == "N") Networking @endif</td>
                <td style="text-align: center;">@if($int->gender == "M") Male @endif @if($int->gender == "F") Female @endif @if($int->gender == "P") Prefer not to say @endif</td>
                <td style="text-align: center">600 hours</td>
            </tr>
            @php $count += 1; @endphp
            @endforeach
        </table>

        <table class="footer">
            <tr>
            @php $count = 0; @endphp
            @foreach ($coordinators as $cd)
                @if($count == 0)
                <th style="text-align: left;">PREPARED BY: </th>
                @else
                <th></th>
                @endif
            @php $count += 1; @endphp
            @endforeach
                <th style="text-align: left;">CERTIFIED CORRECT: </th>
            </tr>
            <tr>
                <th></th>
            </tr>
            <tr>
                @foreach ($coordinators as $cd)
                <td style="text-align: center;"><div style="text-decoration: underline; font-weight: bold; text-transform: uppercase;">{{ $cd->name }}</div><div>OJT Coordinator, CCSIT</div></td>
                @endforeach
                @foreach ($deans as $dn)
                <td style="text-align: center;"><div style="text-decoration: underline; font-weight: bold; text-transform: uppercase;">{{ $dn->name }}</div><div>DEAN, CCSIT</div></td>
                @endforeach
            </tr>
        </table>
    @endif

    @if($val == 2)

    @foreach ($hte as $hte)
    <div class="page">
        <i style="float: right;">Annex "D"</i><br>
        <center>
            <h4>REPORT ON THE LIST HOST TRAINING ESTABLISHMENTS (HTEs) AND STUDENT INTERNS PARTICIPATING IN THE STUDENT <br> INTERNSHIP PROGRAM IN THE PHILIPPINES (SIPP)</h4>
            <h4>AY <span style="text-decoration: underline;">{{ Session::get('year') }}</span></h4>
        </center>

        <h4>HEI: <span style="text-decoration: underline; margin-left: 50px;">SOUTHERN LEYTE STATE UNIVERSIRTY - MAIN</span></h4>
        <H4>ADDRESS: <span style="text-decoration: underline; margin-left: 19px;">SAN ROQUE, SOGOD, SOUTHERN LEYTE, 6606</span></H4>
        <table>
            <tr>
                <th>
                    PARTNER HOST TRAINING <br> ESTABLISHMENTS (HTEs)
                </th>
                <th>
                    NAME OF STUDENT INTERNS
                </th>
                <th>
                    PROGRAM
                </th>
                <th>
                    GENDER
                </th>
                <th>
                    DATES OF DURATION <br> OF THE INTERNSHIP
                </th>
            </tr>
            @php $count = 0; @endphp
            @foreach($interns as $int)
            @if($int->hte == $hte->id)
            <tr>
                <th style="text-align: center;"> @if($count == 0) {{ $hte->name }} @endif</th>
                <td style="text-transform: capitalize;">{{ $int->name }}</td>
                <td>BS Info Tech. @if($int->major == "P") Programming @endif @if($int->major == "N") Networking @endif</td>
                <td style="text-align: center;">@if($int->gender == "M") Male @endif @if($int->gender == "F") Female @endif @if($int->gender == "P") Prefer not to say @endif</td>
                <td style="text-align: center">600 hours</td>
            </tr>
            @php $count += 1; @endphp
            @endif
            @endforeach
        </table>

        <table class="footer">
            <tr>
            @php $count = 0; @endphp
            @foreach ($coordinators as $cd)
                @if($count == 0)
                <th style="text-align: left;">PREPARED BY: </th>
                @else
                <th></th>
                @endif
            @php $count += 1; @endphp
            @endforeach
                <th style="text-align: left;">CERTIFIED CORRECT: </th>
            </tr>
            <tr>
                <th></th>
            </tr>
            <tr>
                @foreach ($coordinators as $cd)
                <td style="text-align: center;"><div style="text-decoration: underline; font-weight: bold; text-transform: uppercase;">{{ $cd->name }}</div><div>OJT Coordinator, CCSIT</div></td>
                @endforeach
                @foreach ($deans as $dn)
                <td style="text-align: center;"><div style="text-decoration: underline; font-weight: bold; text-transform: uppercase;">{{ $dn->name }}</div><div>DEAN, CCSIT</div></td>
                @endforeach
            </tr>
        </table>
    </div>
    @endforeach
    @endif
</body>
</html>

