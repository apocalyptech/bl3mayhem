<?php // vim: set expandtab tabstop=4 shiftwidth=4 autoindent:

/**
 * Borderlands 3 Mayhem Mode Configurator
 * Copyright (C) 2021 CJ Kucera
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the development team nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL CJ KUCERA BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

$MAX_VERSION=1;
require_once('lz-string.php');

class Ability
{

    function __construct($name, $target)
    {
        $this->name = $name;
        $this->target = $target;

        // May as well compute these strings now.
        if ($name == 'None')
        {
            $this->ability_str = 'ModifierAbility=None';
        }
        else
        {
            $classtype = array_slice(explode('.', $name), -1)[0];
            $this->ability_str = 'ModifierAbility=' . $classtype . '\'"' . $this->name . '"\'';
        }

        if ($target == 'None')
        {
            $this->target_str = 'ModifierTarget=None';
        }
        else
        {
            if (strpos($target, '_Enemies') === false)
            {
                $target_classtype = 'OakAbilityEffectTargetResolutionData_OnTeam';
            }
            else
            {
                $target_classtype = 'OakAbilityEffectTargetResolutionData_Enemies';
            }
            $this->target_str = 'ModifierTarget=' . $target_classtype . '\'"' . $this->target . '"\'';
        }
    }

    function to_hotfix()
    {
        return '(' . $this->ability_str . ',' . $this->target_str . ')';
    }
}

class Modifier
{

    function __construct($id, $name, $default_level, $abilities, $weight, $tags, $uistat)
    {
        $this->id = $id;
        $this->name = $name;
        $this->default_level = $default_level;
        $this->abilities = $abilities;
        $this->weight = $weight;
        $this->tags = $tags;
        $this->uistat = $uistat;
        $this->default_level_id = str_replace(' ', '', strtolower($default_level));
    }

    function to_hotfix()
    {
        $ability_strs = array();
        foreach ($this->abilities as $ability)
        {
            $ability_strs[] = $ability->to_hotfix();
        }
        $tag_strs = array();
        foreach ($this->tags as $tag)
        {
            $tag_strs[] = '"' . $tag . '"';
        }
        return '(Modifiers=(' . implode(',', $ability_strs) . '),' .
            'Weight=' . $this->weight . ',' .
            'MutualExclusionTags=(' . implode(',', $tag_strs) . '),' .
            'UIStats=(UIStatData_Text\'"' . $this->uistat . '"\'))';
    }
    
}

class ModSet
{

    function __construct($label, $object_name, $index)
    {
        $this->label = $label;
        $this->object_name = $object_name;
        $this->index = $index;
        $this->css_id = str_replace(' ', '', strtolower($label));
    }

    function to_hotfix()
    {
        return 'MayhemModifierSlotDataAsset\'"' . $this->object_name . '"\'';
    }

}

class MayhemLevel
{

    function __construct($level, $enemy_scale, $xp_scale, $cash_scale, $loot_scale, $pet_scale, $companion_scale, $modsets)
    {
        $this->level = $level;
        $this->enemy_scale = $enemy_scale;
        $this->xp_scale = $xp_scale;
        $this->cash_scale = $cash_scale;
        $this->loot_scale = $loot_scale;
        $this->pet_scale = $pet_scale;
        $this->companion_scale = $companion_scale;
        $this->modsets = $modsets;
    }
}

function show_modifier_list($label, $id, $active_mods)
{
    global $all_modifiers;
    echo "<td>\n";
    echo "<div class=\"modheader\">Mod Pool: $label</div>\n";
    echo "<div class=\"modlist\">\n";
    foreach ($all_modifiers as $mod)
    {
        if (array_key_exists($mod->id, $active_mods))
        {
            $checked = ' checked';
        }
        else
        {
            $checked = '';
        }
        $full_id = $id . '_' . $mod->id;
        echo '<nobr><input type="checkbox" name="' . $full_id . '" id="' . $full_id . '" class="modifier_' . $id . '" onchange="updatelink();"' . $checked . '> ';
        echo '<label for="' . $full_id . '" class="mod_' . $mod->default_level_id . '">';
        echo '[' . $mod->default_level . '] ' . $mod->name . "</label></nobr><br />\n";
    }
    echo "</div>\n";
    echo "</td>\n";
}

function show_mayhem_selector($level, $slot, $cur_idx)
{
    global $all_modsets;
    $full_id = 'mayhem_' . $level->level . '_' . $slot;
    if ($cur_idx == -1)
    {
        $cur_class = 'mod_none';
    }
    else
    {
        $cur_class = 'mod_' . $all_modsets[$cur_idx]->css_id;
    }
    echo 'Mod Pool ' . ($slot+1) . ":\n";
    echo '<select name="' . $full_id . '" id="' . $full_id . '" class="mayhem_pool_select mayhem_' . $level->level . '_pool ' . $cur_class . '" onchange="restyleselect(this); updatelink();">' . "\n";
    echo '<option class="mod_none" value="-1"';
    if ($cur_idx == -1)
    {
        echo ' selected';
    }
    echo ">None</option>\n";
    for ($i=0; $i<count($all_modsets); $i++)
    {
        echo '<option class="mod_' . $all_modsets[$i]->css_id . '" value="' . $i . '"';
        if ($cur_idx == $all_modsets[$i]->index)
        {
            echo ' selected';
        }
        echo '>' . $all_modsets[$i]->label . "</option>\n";
    }
    echo "</select>\n";
    echo "<br />\n";
}

function show_textbox_row($label, $level, $data)
{
    $full_id = 'mayhem_' . $level . '_' . strtolower($label);
    echo "<tr>\n";
    echo '<td style="text-align: right;">' . htmlentities($label) . ":</td>\n";
    echo "<td>\n";
    echo '<input type="text" size="4" name="' . $full_id . '" id="' . $full_id . '" value="' . htmlentities($data) . '" onchange="updatelink();">' . "\n";
    echo '<input type="hidden" name="' . $full_id . '_prev" id="' . $full_id . '_prev" value="' . htmlentities($data) . "\">\n";
    echo "</td>\n";
    echo "</tr>\n";
}

function show_mayhem_config($level, $cur_modsets)
{
    echo "<tr class=\"mayhem_header\">\n";
    echo '<td colspan="3" class="mayhem_header_' . $level->level . '"><h2>Mayhem ' . $level->level . " Configuration</h2></td>\n";
    echo "</tr>\n";
    echo "<tr class=\"mayhem_config\">\n";

    // Modifier Pools
    echo "<td>\n";
    echo "<b>Modifier Pools</b><br />\n";
    for ($i=0; $i<4; $i++)
    {
        show_mayhem_selector($level, $i, $cur_modsets[$i]);
    }
    echo "</td>\n";

    // Scaling
    echo "<td>\n";
    echo "<b>Scaling</b>\n";
    echo "<table class=\"scaling_table\">\n";
    show_textbox_row('Enemy', $level->level, $level->enemy_scale);
    show_textbox_row('XP', $level->level, $level->xp_scale);
    show_textbox_row('Cash', $level->level, $level->cash_scale);
    show_textbox_row('Loot', $level->level, $level->loot_scale);
    echo "</table>\n";
    echo "</td>\n";

    // Buffs
    echo "<td>\n";
    echo "<b>Buffs</b>\n";
    echo "<table class=\"scaling_table\">\n";
    show_textbox_row('Pets', $level->level, $level->pet_scale);
    show_textbox_row('Companions', $level->level, $level->companion_scale);
    echo "</table>\n";
    echo "</td>\n";

    echo "</tr>\n";
}

// Load our data, generated by my dataprocessing scripts
$errors = array();
include_once('mayhem.php');

// Set up what options are preselected
$got_valid_config = false;
if (array_key_exists('config', $_REQUEST))
{
    //$decoded = base64_decode($_REQUEST['config']);
    $decoded = lzstring_decompress_urisafe($_REQUEST['config']);
    $config = json_decode($decoded, true);

    if (is_array($config) and array_key_exists('v', $config))
    {
        if ($config['v'] <= $MAX_VERSION)
        {
            // Make sure to include all datatype checks as we can, in here.
            if (array_key_exists('p', $config)
                && is_array($config['p'])
                && count($config['p']) == 5
                && is_array($config['p'][0])
                && is_array($config['p'][1])
                && is_array($config['p'][2])
                && is_array($config['p'][3])
                && is_array($config['p'][4])
                && array_key_exists('l', $config)
                && is_array($config['l'])
                && count($config['l']) == 11
                && is_array($config['l'][0])
                && is_array($config['l'][1])
                && is_array($config['l'][2])
                && is_array($config['l'][3])
                && is_array($config['l'][4])
                && is_array($config['l'][5])
                && is_array($config['l'][6])
                && is_array($config['l'][7])
                && is_array($config['l'][8])
                && is_array($config['l'][9])
                && is_array($config['l'][10])
                && array_key_exists('s', $config)
                && is_array($config['s'])
                && count($config['s']) == 11
                && is_array($config['s'][0])
                && is_array($config['s'][1])
                && is_array($config['s'][2])
                && is_array($config['s'][3])
                && is_array($config['s'][4])
                && is_array($config['s'][5])
                && is_array($config['s'][6])
                && is_array($config['s'][7])
                && is_array($config['s'][8])
                && is_array($config['s'][9])
                && is_array($config['s'][10])
                && count($config['s'][0]) == 6
                && count($config['s'][1]) == 6
                && count($config['s'][2]) == 6
                && count($config['s'][3]) == 6
                && count($config['s'][4]) == 6
                && count($config['s'][5]) == 6
                && count($config['s'][6]) == 6
                && count($config['s'][7]) == 6
                && count($config['s'][8]) == 6
                && count($config['s'][9]) == 6
                && count($config['s'][10]) == 6
                )
            {
                $got_valid_config = true;
            }
            else
            {
                $errors[] = 'Parsing error in configuration string';
            }
        }
        else
        {
            $errors[] = 'Invalid configuration version';
        }
    }
    else
    {
        $errors[] = 'Invalid configuration string';
    }
}
if (!$got_valid_config)
{
    $config = $default_config;
}

// Now process our config.
$cur_easy = array();
$cur_medium = array();
$cur_hard = array();
$cur_veryhard = array();
$cur_m11 = array();
$cur_modsets = array();

// First up: Easy/Med/Hard/VeryHard/M11 modifier pools
$loading = array(
    &$cur_easy,
    &$cur_medium,
    &$cur_hard,
    &$cur_veryhard,
    &$cur_m11,
);
for ($category=0; $category<5; $category++)
{
    $temp_hash = array();
    foreach ($config['p'][$category] as $index)
    {
        $temp_hash[$index] = true;
    }
    for ($i=0; $i<count($all_modifiers); $i++)
    {
        if (array_key_exists($i, $temp_hash))
        {
            $loading[$category][$all_modifiers[$i]->id] = true;
        }
    }
}

// Now: Mayhem Level Pool config
$cur_modsets = array();
for ($level=0; $level<11; $level++)
{
    // Mod Pools
    $new_modsets = array();
    for ($i=0; $i<4; $i++)
    {
        if (array_key_exists($i, $config['l'][$level]))
        {
            $new_modsets[] = $config['l'][$level][$i];
        }
        else
        {
            $new_modsets[] = -1;
        }
    }
    $cur_modsets[] = $new_modsets;

    // Scaling stuff; just set it right on the object.
    // ...  why exactly aren't I doing that for everything else?
    $mayhem_levels[$level]->enemy_scale = floatval($config['s'][$level][0]);
    $mayhem_levels[$level]->xp_scale = floatval($config['s'][$level][1]);
    $mayhem_levels[$level]->cash_scale = floatval($config['s'][$level][2]);
    $mayhem_levels[$level]->loot_scale = floatval($config['s'][$level][3]);
    $mayhem_levels[$level]->pet_scale = floatval($config['s'][$level][4]);
    $mayhem_levels[$level]->companion_scale = floatval($config['s'][$level][5]);
}

/*
 * Old "default" config; should probably refactor various processing
 * bits all over here, honestly.
 *
    $cur_easy = $default_easy;
    $cur_medium = $default_medium;
    $cur_hard = $default_hard;
    $cur_veryhard = $default_veryhard;
    $cur_m11 = $default_mayhem11;
    $cur_modsets = array();
    foreach ($mayhem_levels as $level)
    {
        $new_modsets = array();
        for ($i=0; $i<4; $i++)
        {
            if (array_key_exists($i, $level->modsets))
            {
                $new_modsets[] = $level->modsets[$i]->index;
            }
            else
            {
                $new_modsets[] = -1;
            }
        }
        $cur_modsets[] = $new_modsets;
    }
}
 */

// Generate the modfile if we've been told to do so
if (array_key_exists('action', $_POST) and $_POST['action'] == 'generate')
{
    // TODO: re-enable this when I'm done testing.
    header('Content-Disposition: attachment; filename="mayhem_mode_customization.bl3hotfix"');
    header('Content-Type: text/plain');
    header('Content-Description: Mayhem Mode Customization BL3 Hotfix Mod');
?>
###
### Name: Mayhem Mode Customization
### Version: 1.0.0
### Author: Apocalyptech
### Contact: https://apocalyptech.com/contact.php
###
### License: Commons CC0 1.0 Universal (CC0 1.0) Public Domain Dedication
### License URL: https://creativecommons.org/publicdomain/zero/1.0/
###

###
### Contains customizations chosen at https://apocalyptech.com/games/bl3-mayhem/
### Link to this specific customization set, in case you'd like to tweak it:
###
###   https://apocalyptech.com/games/bl3-mayhem/index.php?config=<?php echo $_POST['config'] . "\n" ?>
###

<?

    # Mayhem Level Configs should happen first, in case we've lost any references
    # and caused any ModSets to get garbage collected; that seems to happen *real*
    # quick with these, if the references are lost.
    echo "###\n";
    echo "### Mayhem Level Configs\n";
    echo "###\n";
    echo "\n";
    $table = '/Game/PatchDLC/Mayhem2/Abilities/CoreModifierSets/Table_Mayhem2CoreModifierSet.Table_Mayhem2CoreModifierSet';
    for ($level=0; $level<11; $level++)
    {
        $modsets = array();
        foreach ($cur_modsets[$level] as $modset_idx)
        {
            if ($modset_idx >= 0 and array_key_exists($modset_idx, $all_modsets))
            {
                $modsets[] = $all_modsets[$modset_idx]->to_hotfix();
            }
        }
        echo '# Mayhem ' . ($level+1) . "\n";
        echo 'SparkPatchEntry,(1,1,0,),/Game/PatchDLC/Mayhem2/OverrideModSet_Mayhem2.OverrideModSet_Mayhem2,' .
            'PerLevelOverrides.PerLevelOverrides[' . $level . '].RandomModifierSlotsOverride,0,,' .
            '(' . implode(',', $modsets) . ")\n";

        $mh_level = $mayhem_levels[$level];
        $hf_start = 'SparkPatchEntry,(1,2,0,),' . $table . ',' . ($level+1) . ',';
        echo $hf_start . 'HealthSimpleScalar_42_0499AACF43FDF39B7084E2BB63E4BF68,0,,' . $mh_level->enemy_scale . "\n";
        echo $hf_start . 'ShieldSimpleScalar_43_417C36C54DA2550A4CABC7B26A5E24A8,0,,' . $mh_level->enemy_scale . "\n";
        echo $hf_start . 'ArmorSimpleScalar_44_BCAAA445479831C25B0D55AF294A15D6,0,,' . $mh_level->enemy_scale . "\n";
        echo $hf_start . 'ExpGainScalar_39_2159F009466933AA733AE688E55B1B93,0,,' . $mh_level->xp_scale . "\n";
        echo $hf_start . 'CashScalar_22_B7B11DC94BBB45C94A96279146EC193E,0,,' . $mh_level->cash_scale . "\n";
        echo $hf_start . 'LootQuality_56_03E220E0495C6B37CD6C7195F5EA289B,0,,' . $mh_level->loot_scale . "\n";
        echo $hf_start . 'PetHealth_84_E5B903B4452F4310CCD13C931474E12B,0,,' . $mh_level->pet_scale . "\n";
        echo $hf_start . 'CompanionHealth_89_294A6BE7439072AE9F934CAA127D8D83,0,,' . $mh_level->companion_scale . "\n";
        echo "\n";
    }

    # Now all our stuff w/ setting the Mayhem pools themselves.
    $currents = array(
        $cur_easy,
        $cur_medium,
        $cur_hard,
        $cur_veryhard,
        $cur_m11,
    );
    $labels = array('Easy', 'Medium', 'Hard', 'Very Hard', 'Mayhem 11');
    $objects = array(
        '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_EAsy.ModSet_Mayhem2_EAsy',
        '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_Medium.ModSet_Mayhem2_Medium',
        '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_Hard.ModSet_Mayhem2_Hard',
        '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_VeryHard.ModSet_Mayhem2_VeryHard',
        '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_Mayhem11.ModSet_Mayhem2_Mayhem11',
    );

    echo "###\n";
    echo "### Mayhem Modifier Pools\n";
    echo "###\n";
    echo "\n";
    for ($category=0; $category<5; $category++)
    {
        $modifiers = array();
        foreach ($all_modifiers as $modifier)
        {
            if (array_key_exists($modifier->id, $currents[$category]))
            {
                $modifiers[] = $modifier->to_hotfix();
            }
        }
        echo '# Active Mayhem Modifiers for ' . $labels[$category] . "\n";
        echo 'SparkPatchEntry,(1,1,0,),' .
            $objects[$category] . ',' .
            'ModifierSets,0,,' .
            '(' . implode(',', $modifiers) . ")\n";
        echo "\n";
    }

    exit;
}

// Site header
include('../../inc/apoc.php');
$page->set_title('Borderlands 3 Mayhem Mode Configurator');
$page->add_css('mayhem.css', 1);
$page->add_js('lz-string.min.js', 1);
$page->add_js('mayhem.js', 1);
$page->add_onload('updatelink();');
$page->add_changelog('foo', 'Initial release');
$page->apoc_header();

?>

<noscript><h1>Note: Alas, this page does require Javascript.  Sorry!</h1></noscript>

<p>
<span style="font-size: bigger; font-weight: bold; color: red;">Warning!</span> - this is
still a work in progress.  It may break at any point, start looking different (or have
bits rearranged, etc), old codes may stop working, and the mods it generates could have
unintended side effects or just not work at all.  So, y'know, there's that.
</p>

<p>
Regardless, click around all you want, and hit the "Generate Mod" button when you want
to download the mod.  Bookmark the URL if you want to come back to the configuration
later (though see the above warning about those codes possibly breaking at any point
while this is in development).  At the moment you must add the file to B3HM as a local
file; I'm unsure whether or not I'll have "live" web-based hotfix delivery here.
</p>

<table class="control_area">

<tr>
<td colspan="3">
<div class="modlink">
<b>URL to this configuration:</b> <a href="https://apocalyptech.com/games/bl3-mayhem/" id="modlink_a">https://apocalyptech.com/games/bl3-mayhem/</a>
</div>
</td>
</tr>

<tr>
<td>
<div class="modgen">
<form action="index.php" method="POST">
<input type="hidden" name="action" value="generate">
<input type="hidden" name="config" id="generation_config" value="">
<input type="submit" value="Generate Modfile">
</form>
</div>
</td>
<td>/</td>
<td class="biggest_cell">
<div class="modreset">
<form action="index.php" method="GET">
<input type="submit" value="Reset To Defaults">
</form>
</div>
</td>
</tr>
</table>

<?php
// Show errors, if we've got 'em
if (count($errors) > 0)
{
    echo "<div class=\"bad\">\n";
    echo "Errors while processing:<br />\n";
    echo "<ul>\n";
    foreach ($errors as $error)
    {
        echo "<li>$error</li>\n";
    }
    echo "</ul>\n";
    echo "</div>\n";
}
?>

<table class="leveltable">
<?php
foreach ($mayhem_levels as $level)
{
    show_mayhem_config($level, $cur_modsets[$level->level-1]);
}
?>
</table>

<h2 class="pool_config_header">Modifier Pool Configuration</h2>

<div class="modtable_container">
<table class="modtable">
<tr>
<?php
show_modifier_list('Easy', '0', $cur_easy);
show_modifier_list('Medium', '1', $cur_medium);
show_modifier_list('Hard', '2', $cur_hard);
show_modifier_list('Very Hard', '3', $cur_veryhard);
show_modifier_list('Mayhem 11', '4', $cur_m11);
?>
</tr>
</table>
</div>

<? $page->apoc_footer(); ?>

