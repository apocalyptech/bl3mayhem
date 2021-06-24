<?php // vim: set expandtab tabstop=4 shiftwidth=4:

/**
 * PHP Port (and slight tweaking) of one specific decompression component
 * of pieroxy's lz-string:
 *
 *    https://github.com/pieroxy/lz-string
 *    https://pieroxy.net/blog/pages/lz-string/index.html
 *
 * Specifically, this only implements lz-string's
 * `decompressFromEncodedURIComponent` function, since that's all
 * we're using it for.  Additionally, the decompression function assumes
 * latin1/ASCII characters, whereas the original allows utf-16.  This is
 * fine for our own purposes here, but does make it less general-purpose.
 * To support utf-16, all instances of `chr()` in here would need to be
 * converted to an equivalent of Javascript's `String.fromCharCode`.
 *
 * Port by CJ Kucera / apocalyptech, though all credit should go to pieroxy.
 *
 * --
 *
 * MIT License
 *
 * Copyright (c) 2013 pieroxy
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

// For debugging purposes
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 */

// Also for debugging purposes
function report($string)
{
    echo $string . "<br>\n";
}

// Also for debugging purposes
function report_r($string, $data)
{
    echo $string . ': ';
    print_r($data);
    echo "<br>\n";
}

function lzstring_decompress_urisafe($compressed)
{
    // Convert spaces to plusses
    $compressed = str_replace(' ', '+', $compressed);

    // Hardcoding the single URI-safe encoding
    $keyStrUriSafe = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+-$';
    $baseReverseDic = array();
    for ($i=0; $i<strlen($keyStrUriSafe); $i++)
    {
        $baseReverseDic[$keyStrUriSafe[$i]] = $i;
    }

    // Initial vars
    $length = strlen($compressed);
    $getNextValue = function($index) use ($compressed, $baseReverseDic) {
        return $baseReverseDic[$compressed[$index]];
    };

    $resetValue = 32;
    $dictionary = array(0 => 0, 1 => 1, 2 => 2);
    $enlargeIn = 4;
    $dictSize = 4;
    $numBits = 3;
    $entry = '';
    $result = array();
    $data = array(
        'val' => $getNextValue(0),
        'position' => $resetValue,
        'index' => 1,
    );

    // And now onto the work!
    $bits = 0;
    $maxpower = pow(2,2);
    $power = 1;
    while ($power != $maxpower)
    {
        $resb = $data['val'] & $data['position'];
        $data['position'] >>= 1;
        if ($data['position'] == 0)
        {
            $data['position'] = $resetValue;
            $data['val'] = $getNextValue($data['index']++);
        }
        $bits |= ($resb>0 ? 1 : 0) * $power;
        $power <<= 1;
    }

    $next = $bits;
    switch ($next)
    {
        case 0:
            $bits = 0;
            $maxpower = pow(2, 8);
            $power = 1;
            while ($power != $maxpower)
            {
                $resb = $data['val'] & $data['position'];
                $data['position'] >>= 1;
                if ($data['position'] == 0)
                {
                    $data['position'] = $resetValue;
                    $data['val'] = $getNextValue($data['index']++);
                }
                $bits |= ($resb>0 ? 1 : 0) * $power;
                $power <<= 1;
            }
            $c = chr($bits);
            break;

        case 1:
            $bits = 0;
            $maxpower = pow(2, 16);
            $power = 1;
            while ($power != $maxpower)
            {
                $resb = $data['val'] & $data['position'];
                $data['position'] >>= 1;
                if ($data['position'] == 0)
                {
                    $data['position'] = $resetValue;
                    $data['val'] = $getNextValue($data['index']++);
                }
                $bits |= ($resb>0 ? 1 : 0) * $power;
                $power <<= 1;
            }
            $c = chr($bits);
            break;

        case 2:
            return '';
    }

    $dictionary[3] = $c;
    $w = $c;
    $result[] = $c;
    while (true)
    {
        if ($data['index'] > $length)
        {
            return '';
        }

        $bits = 0;
        $maxpower = pow(2, $numBits);
        $power = 1;
        while ($power != $maxpower)
        {
            $resb = $data['val'] & $data['position'];
            $data['position'] >>= 1;
            if ($data['position'] == 0)
            {
                $data['position'] = $resetValue;
                $data['val'] = $getNextValue($data['index']++);
            }
            $bits |= ($resb>0 ? 1 : 0) * $power;
            $power <<= 1;
        }

        $c = $bits;
        switch ($c)
        {
            case 0:
                $bits = 0;
                $maxpower = pow(2, 8);
                $power = 1;
                while ($power != $maxpower)
                {
                    $resb = $data['val'] & $data['position'];
                    $data['position'] >>= 1;
                    if ($data['position'] == 0)
                    {
                        $data['position'] = $resetValue;
                        $data['val'] = $getNextValue($data['index']++);
                    }
                    $bits |= ($resb>0 ? 1 : 0) * $power;
                    $power <<= 1;
                }
                
                $dictionary[$dictSize++] = chr($bits);
                $c = $dictSize-1;
                $enlargeIn--;
                break;

            case 1:
                $bits = 0;
                $maxpower = pow(2, 16);
                $power = 1;
                while ($power != $maxpower)
                {
                    $resb = $data['val'] & $data['position'];
                    $data['position'] >>= 1;
                    if ($data['position'] == 0)
                    {
                        $data['position'] = $resetValue;
                        $data['val'] = $getNextValue($data['index']++);
                    }
                    $bits |= ($resb>0 ? 1 : 0) * $power;
                    $power <<= 1;
                }

                $dictionary[$dictSize++] = chr($bits);
                $c = $dictSize-1;
                $enlargeIn--;
                break;

            case 2:
                return implode('', $result);

        }

        if ($enlargeIn == 0)
        {
            $enlargeIn = pow(2, $numBits);
            $numBits++;
        }

        if (array_key_exists($c, $dictionary))
        {
            $entry = $dictionary[$c];
        }
        else
        {
            if ($c === $dictSize)
            {
                // TODO:
                // This doesn't seem to pop up in our cases (at least I hadn't seen it yet)
                // but I am *pretty* sure this is meant to be a string contact
                $entry = $w . $w[0];
            }
            else
            {
                return null;
            }
        }
        $result[] = $entry;

        // Add w+entry[0] to the dictionary
        $dictionary[$dictSize++] = $w . $entry[0];
        $enlargeIn--;

        $w = $entry;

        if ($enlargeIn == 0)
        {
            $enlargeIn = pow(2, $numBits);
            $numBits++;
        }

    }

}

