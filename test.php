<?php // vim: set expandtab tabstop=4 shiftwidth=4:

require_once('lz-string.php');
//$uristring = 'N4IgbiBcCMA0IEMC2UDaqAMs4CZYGZYAWWAVgF1ZUA2WAdlgA5YBObLaOaPaQ6E6BSrRa0BtGbQ2OLDmiVUOPDkI4SOUrBy0cdBTkblKIJAAc0mBRyvZsNnDdyPbDqrK038zr25cEFREbwAM4WeBgAdOFRdlQkkfERJD40sJG06WQKzJE5Ecx0EUKogrZcGAr4HDHQNSlEmrUCSdjUCtTVohGiLNnVkvlariUY7srF0KNl2DhFRgC+QA';
//$uristring = 'N4IgbiBcCMA0IEMC2UDaqAMBdWqCsOqAzIdIdjiEgA5qaxm4YPkMtOwBMsJHcnrOP1bcBHXvTgTm-HoQAsWSgGc6nDMwwA6btu6NU82NqMm5uAGzGtV7VYK4AHNefbnAdi0PU0PGyHYuEQyOgyh0BLyftBaRjFxFoQWIVYxqQCchI4hzjHOnGI+GlwlnN7QxUIMnF5KAL5AA';
//$uristring = 'N4IgbiBcCMA0IAcoG1kAZZwEywMywBZYBWAXVmQDZYB2WADlgE5MNo5odp9ojoyK0atDrRG0FlgxZo5ZFhxZ8WIlmKws1LDTlZ6pciAA2KZMsyw0cttYuyK029icWstxbdwuvD13jkEBvAAzqbQGCyMdNQCyERoAHTxSXgaCWqYCZRqctSJeVkkafQ06tAJTLilcoyJtQlRCeq4TWk5gmV2GAQJnOpYTdmxuGzpmVz4PaXF1RQEZSnlfDEJVc29JbGUo8KFErDULbH0o+INGjiUWRkt9H1y4dIaGuo06eo994JobHYDr+9CL0cqQAL5AA';
//$uristring = 'N4IgbiBcCMA0IAcoG1kAZZwEywMywBZYBWWANlgHZYAOWATkw2jmh2n2iOlOgumrQ60RlgxZsOLPixEspLBSzUsNALqx0mWDnxFSFanUbRmrdp269+g4aPGSdMuQqUr1m5jryES5KrQMTJjmmJaY1pi2mPY6jtI6LjpuOh5a2D76-kZBpiGYFphWmDaYdjoOOlLOOq467hrp3np+hoEmZgVhRRElUWUxFXFVTom1yfWpahogADYoyDLaaI1e4qva2BvseBsZWHvaB57eOCsn+JeHVycZuI1Ej4TT8ADOC1gAdGy4BArf0j+OgBv3+PyBX3BYMBxEakJhwKhiIR8NByLRqL+cJBEJx0IxePRuKh2KRmPxxJRhPJpKpZOpDPpJM05KJFPZbLZtIJTLpfJ5MO5lIFIuFYthLMZ-PFnJpkt5oo5rLlyGVUsVsrx0wAvkA';
//$uristring = 'N4IgbiBcCMA0IAcoG1kAZZwEywMywBZYBWWANlgHZYAOWATkw2jmh2n2iOlOgumrQ60RlgxZsOLPixEspLBSzUsNALqx0mWDnxFSFanUbRmrdp269+g4aPGSdMuQqUr1m5jryES5KrQMTJjmmJaY1pi2mPY6jtI6LjpuOh5a2D76-kZBpiGYFphWmDaYdjoOOlLOOq467hrp3np+hoEmZgVhRRElUWUxFXFVTom1yfWpahogADYoyDLaaI1e4qva2BvseBsZWHvaB57eOCsn+JeHVycZuI1Ej4TT8ADOC1gAdGy4BKQE9Fwn1keAINHwNE+uHoujBQJkuEh0nojUhAJoxF0NAInwIl2xUIkDBo2OIULwULhsKBqka0OghKIvz+wLgv0pqjwslxjEBBEoDKkHG+BGgjS+bBo9Ee9Fx2L09DRlwILL+BV+2NB4OBD1w0LRDBxuFUjAJeJw-JpTO1v1o0qRdNkZto7LQ0NBrrZaAkPNBUO9UgBRvF2oSAPhdAkRrQTLBNpdUONbPNwIIqOkErZUqNOEYv2NALCqnhhEBZfFiLlWspCb1RCRWASskrypjnzIqLJiMRhGIlEoZKIZDIxBVn1IiL7XwUvwH48SuH70jplrJo7w8txVGINDIuPxRon-P77YYO779zUAF8gA';
//$uristring = 'N4IgbiBcCMA0IAcoG1kAZZwEywMywBZYBWAXVmQDZYB2WADlgE5MNo5odp9ojoyK0atDrRG0FlgxZo5ZFhxZ8WIlmKws1LDTlZ6pciAA2KdHLbnMmS1kvY7V2xWkbLuB++eO8cggfgAzqY4aAB0IeFW0KGUapihuJzqcMRsaNL06vTp8cKR0Xyhqrl5HJFY4ckx1AC0YWhxYU7IRGGtRXgalblxHDlSGMQ0bJT9+R3R4qGMyglc40S4oeoVuDh1oWjqbXLUYXsxJF30NFVMuKdRqXg5mSsEY1Na5ZGqoUxTPIcEoZcVH7ANmhLvs5IwwuDprRlngYRVehocg82LwMGscktCowKs9qOolpRCljYNQCUQNnAIXJ+FFWIRQkkusRYskNNdUmwCHFkYM4TCiER6DDiO8qn8YTRuiKmOoKb05Lg2OMuPgfuKTqy1IMciJoBgCNk0oRaCahKx3kzjULkmEWBSqs0CFUiZg8QlLksxJdsOz+ulBqNOcKYXq6UoQyLMrC4iL1ExfslI7KwiJnbslXlhCxSSG2drpP6ScjMCxRDx8IlEVCiKJsBDAU1cmClVNsThKDE4kt6IyffnETkaAM2cxMKI6ARsJKiHHMPCVtOG+FetNqf0NCPJdyGQitSQ-bdC5WzTINCk4LgiMIOEt8eSmis12wohV1Fv1D9e3n95zuUeOFo2DnngV6YDeMKXkuvYGAAvkAA';
$uristring = 'N4IgbiBcBMA0IAcoG1kAZYEZZwMywBZYBWAXVmQDZYB2WADlgE4sNNtM5N9MjMyKmapjqZGmFtAzRM5ZNDjR80ItGI5q0GnOj1S5EABsU6OWzNYsF6Bew2KbS-fQ4cF3LdgeHTr3IL68ADOJnBoAHRhkZaY4ZRqWOG4nOocaGzpJNKpcYlc4XwFrrGUwuEc0dCROaWwALQR6QkRzkQRbUXK1YnxqawZGMQYuOpV+YXi4YxduPnjXuGjSWGw7XLUERu5S-Q0OUy4ezGZKf2wlNJTPTiV0arhTJM8uQThR1WPq6txcowRf1caIsFksEtgjqdTjRhkVYowqpptgtKIUJudkW1vnpBH00oRygkqsRepYIScEkdiMCiYRafRgVSmDl3sCgQlGepzBRcGxorEuPhXizdn0yWwhswMrS6KJhBFJOE0OoiPTUvKvvz-DlUVhqFTDupcOURaT1O8TidXuoqWrWDgjakqfQlnrgUw3o6ppzEgEKBdriUsCxqA7LBL3mDMGwWKIePhkjh-gtwVg7EneZRfrzJvC4JQ4gkjfRIVlaKMJacEiwRFg6AQ7ECiEXmFgxqNGxqpnIo9JXBTuq8SxKJWpxcMOJo7NhiNhcEQramsKG518bKQAL5AA';

?>
<html>
<head>
<title>Testing</title>
<style type="text/css">
.good {
    color: green;
}
.bad {
    color: red;
}
</style>
<script language="javascript" type="text/javascript" src="lz-string.min.js?v=1"></script>
<script type="text/javascript">
<!--
function doStuff()
{
    uristring = '<?php echo $uristring; ?>';
    data = LZString.decompressFromEncodedURIComponent(uristring);
    element = document.getElementById('jsresult');
    element.innerHTML = data;

    phpdata = document.getElementById('php_result').innerHTML;

    result = document.getElementById('result');
    if (phpdata == data)
    {
        result.innerHTML = 'Good';
        result.className = 'good';
    }
    else
    {
        result.innerHTML = 'Bad';
        result.className = 'bad';
    }
}
//-->
</script>
</head>
<body onload="doStuff();">

<p>
Javascript result:
<pre id="jsresult">foo</pre>
</p>

<p>
PHP result:
<pre id="php_result"><?php echo lzstring_decompress_urisafe($uristring); ?></pre>
</p>

<p>
Test:
<span id="result">unknown</span>
</p>

</body>
</html>
