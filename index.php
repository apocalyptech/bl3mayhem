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

// NOTE: This URL is also hardcoded in mayhem.js, so be sure to change it there, too.
// Should include the trailing slash, though that only matters for the in-mod link.
$BASE_URL='https://apocalyptech.com/games/bl3-mayhem/';
$MAX_VERSION=2;
require_once('lz-string.php');

/**
 * Config string version history:
 *
 * v1 - Initial release
 * v2 - Despite *visually* taking its numbers from the Mayhem 11 table values,
 *      M11 *actually* just uses the M10 values behind the scenes, so v2 removes
 *      the M11 stats string entirely, and the mod-generation section will
 *      explicitly re-use the M10 stats, to ensure that it visually looks right.
 */

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

    function __construct($level,
        $enemy_scale, $xp_scale, $cash_scale, $loot_scale, $pet_scale, $companion_scale,
        $white_scale, $green_scale, $blue_scale, $purple_scale, $orange_scale,
        $dam_as, $dam_melee, $dam_slide, $dam_slam, $dam_pet,
        $dam_env, $dam_passive, $dam_veh_dealt, $dam_veh_taken, $dam_gear,
        $dropnum, $eridium,
        $modsets)
    {
        $this->level = $level;
        $this->enemy_scale = $enemy_scale;
        $this->xp_scale = $xp_scale;
        $this->cash_scale = $cash_scale;
        $this->loot_scale = $loot_scale;
        $this->pet_scale = $pet_scale;
        $this->companion_scale = $companion_scale;
        $this->white_scale = $white_scale;
        $this->green_scale = $green_scale;
        $this->blue_scale = $blue_scale;
        $this->purple_scale = $purple_scale;
        $this->orange_scale = $orange_scale;
        $this->dam_as = $dam_as;
        $this->dam_melee = $dam_melee;
        $this->dam_slide = $dam_slide;
        $this->dam_slam = $dam_slam;
        $this->dam_pet = $dam_pet;
        $this->dam_env = $dam_env;
        $this->dam_passive = $dam_passive;
        $this->dam_veh_dealt = $dam_veh_dealt;
        $this->dam_veh_taken = $dam_veh_taken;
        $this->dam_gear = $dam_gear;
        $this->dropnum = $dropnum;
        $this->eridium = $eridium;
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

function show_textbox_row($label, $id, $level, $data)
{
    $full_id = 'mayhem_' . $level . '_' . $id;
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
    echo '<td colspan="6" class="mayhem_header_' . $level->level . '"><h2>Mayhem ' . $level->level . " Configuration</h2></td>\n";
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

    // Scaling, assuming we're M1-M10
    if ($level->level < 11)
    {

        // Scaling + Buffs
        echo "<td>\n";
        echo "<table class=\"scaling_table\">\n";
        echo "<tr><td colspan=\"2\">\n";
        echo "<b>Scaling</b>\n";
        echo "</td></tr>\n";
        show_textbox_row('Enemy', 'enemy', $level->level, $level->enemy_scale);
        show_textbox_row('XP', 'xp', $level->level, $level->xp_scale);
        show_textbox_row('Cash', 'cash', $level->level, $level->cash_scale);
        show_textbox_row('Loot', 'loot', $level->level, $level->loot_scale);
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr><td colspan=\"2\">\n";
        echo "<b>Buffs</b>\n";
        echo "</td></tr>\n";
        show_textbox_row('Pets', 'pets', $level->level, $level->pet_scale);
        show_textbox_row('Companions', 'companions', $level->level, $level->companion_scale);
        echo "</table>\n";
        echo "</td>\n";

        // Drop Weight Modifiers
        echo "<td>\n";
        echo "<table class=\"scaling_table\">\n";
        echo "<tr><td colspan=\"2\">\n";
        echo "<b>Drop Weight Scaling</b>\n";
        echo "</td></tr>\n";
        show_textbox_row('White', 'white', $level->level, $level->white_scale);
        show_textbox_row('Green', 'green', $level->level, $level->green_scale);
        show_textbox_row('Blue', 'blue', $level->level, $level->blue_scale);
        show_textbox_row('Purple', 'purple', $level->level, $level->purple_scale);
        show_textbox_row('Orange', 'orange', $level->level, $level->orange_scale);
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr><td colspan=\"2\">\n";
        echo "<b>Drop Changes</b>\n";
        echo "</td></tr>\n";
        show_textbox_row('Drop Number', 'dropnum', $level->level, $level->dropnum);
        show_textbox_row('Eridium Chance', 'eridium', $level->level, $level->eridium);
        echo "</table>\n";
        echo "</td>\n";

        // Damage
        echo "<td>\n";
        echo "<b>Damage Scaling</b>\n";
        echo "<table class=\"scaling_table\">\n";
        show_textbox_row('Action Skill', 'dam_as', $level->level, $level->dam_as);
        show_textbox_row('Melee', 'dam_melee', $level->level, $level->dam_melee);
        show_textbox_row('Slide', 'dam_slide', $level->level, $level->dam_slide);
        show_textbox_row('Slam', 'dam_slam', $level->level, $level->dam_slam);
        show_textbox_row('Pet', 'dam_pet', $level->level, $level->dam_pet);
        show_textbox_row('Environment', 'dam_env', $level->level, $level->dam_env);
        show_textbox_row('Passive', 'dam_passive', $level->level, $level->dam_passive);
        show_textbox_row('Vehicle (dealt)', 'dam_veh_dealt', $level->level, $level->dam_veh_dealt);
        show_textbox_row('Vehicle (taken)', 'dam_veh_taken', $level->level, $level->dam_veh_taken);
        show_textbox_row('Gear', 'dam_gear', $level->level, $level->dam_gear);
        echo "</table>\n";
        echo "</td>\n";

    } else {

        // Just a note about M11 scaling
        echo "<td colspan=\"3\">\n";
        echo "<b>Note:</b><br />\n";
        echo "Mayhem 11 always inherits from Mayhem 10 stats, so the various scaling<br />\n";
        echo "parameters are not available here.\n";
        echo "</td>\n";

    }

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
        $version = $config['v'];
        if ($version <= $MAX_VERSION)
        {
            if ($version == 1)
            {
                $expected_mayhem_stats = 11;
            }
            else
            {
                $expected_mayhem_stats = 10;
            }
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
                && count($config['s']) == $expected_mayhem_stats
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
                && ($version > 1 || is_array($config['s'][10]))
                && count($config['s'][0]) == 23
                && count($config['s'][1]) == 23
                && count($config['s'][2]) == 23
                && count($config['s'][3]) == 23
                && count($config['s'][4]) == 23
                && count($config['s'][5]) == 23
                && count($config['s'][6]) == 23
                && count($config['s'][7]) == 23
                && count($config['s'][8]) == 23
                && count($config['s'][9]) == 23
                && ($version > 1 || count($config['s'][10]) == 23)
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
    if ($level < 10)
    {
        $mayhem_levels[$level]->enemy_scale = floatval($config['s'][$level][0]);
        $mayhem_levels[$level]->xp_scale = floatval($config['s'][$level][1]);
        $mayhem_levels[$level]->cash_scale = floatval($config['s'][$level][2]);
        $mayhem_levels[$level]->loot_scale = floatval($config['s'][$level][3]);
        $mayhem_levels[$level]->pet_scale = floatval($config['s'][$level][4]);
        $mayhem_levels[$level]->companion_scale = floatval($config['s'][$level][5]);
        $mayhem_levels[$level]->white_scale = floatval($config['s'][$level][6]);
        $mayhem_levels[$level]->green_scale = floatval($config['s'][$level][7]);
        $mayhem_levels[$level]->blue_scale = floatval($config['s'][$level][8]);
        $mayhem_levels[$level]->purple_scale = floatval($config['s'][$level][9]);
        $mayhem_levels[$level]->orange_scale = floatval($config['s'][$level][10]);
        $mayhem_levels[$level]->dam_as = floatval($config['s'][$level][11]);
        $mayhem_levels[$level]->dam_melee = floatval($config['s'][$level][12]);
        $mayhem_levels[$level]->dam_slide = floatval($config['s'][$level][13]);
        $mayhem_levels[$level]->dam_slam = floatval($config['s'][$level][14]);
        $mayhem_levels[$level]->dam_pet = floatval($config['s'][$level][15]);
        $mayhem_levels[$level]->dam_env = floatval($config['s'][$level][16]);
        $mayhem_levels[$level]->dam_passive = floatval($config['s'][$level][17]);
        $mayhem_levels[$level]->dam_veh_dealt = floatval($config['s'][$level][18]);
        $mayhem_levels[$level]->dam_veh_taken = floatval($config['s'][$level][19]);
        $mayhem_levels[$level]->dam_gear = floatval($config['s'][$level][20]);
        $mayhem_levels[$level]->dropnum = floatval($config['s'][$level][21]);
        $mayhem_levels[$level]->eridium = floatval($config['s'][$level][22]);
    }
}

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
### Contains customizations chosen at <?php echo $BASE_URL . "\n"; ?>
### Link to this specific customization set, in case you'd like to tweak it:
###
###   <?php echo $BASE_URL; ?>index.php?config=<?php echo $_POST['config'] . "\n" ?>
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
        if ($level == 10)
        {
            $extra_header = ' (stats duplicated from M10)';
        }
        else
        {
            $extra_header = '';
        }
        echo '# Mayhem ' . ($level+1) . $extra_header . "\n";
        echo 'SparkPatchEntry,(1,1,0,),/Game/PatchDLC/Mayhem2/OverrideModSet_Mayhem2.OverrideModSet_Mayhem2,' .
            'PerLevelOverrides.PerLevelOverrides[' . $level . '].RandomModifierSlotsOverride,0,,' .
            '(' . implode(',', $modsets) . ")\n";

        if ($level < 10)
        {
            $mh_level = $mayhem_levels[$level];
        }
        else
        {
            $mh_level = $mayhem_levels[9];
        }
        $hf_start = 'SparkPatchEntry,(1,2,0,),' . $table . ',' . ($level+1) . ',';
        echo $hf_start . 'HealthSimpleScalar_42_0499AACF43FDF39B7084E2BB63E4BF68,0,,' . $mh_level->enemy_scale . "\n";
        echo $hf_start . 'ShieldSimpleScalar_43_417C36C54DA2550A4CABC7B26A5E24A8,0,,' . $mh_level->enemy_scale . "\n";
        echo $hf_start . 'ArmorSimpleScalar_44_BCAAA445479831C25B0D55AF294A15D6,0,,' . $mh_level->enemy_scale . "\n";
        echo $hf_start . 'ExpGainScalar_39_2159F009466933AA733AE688E55B1B93,0,,' . $mh_level->xp_scale . "\n";
        echo $hf_start . 'CashScalar_22_B7B11DC94BBB45C94A96279146EC193E,0,,' . $mh_level->cash_scale . "\n";
        echo $hf_start . 'LootQuality_56_03E220E0495C6B37CD6C7195F5EA289B,0,,' . $mh_level->loot_scale . "\n";
        echo $hf_start . 'PetHealth_84_E5B903B4452F4310CCD13C931474E12B,0,,' . $mh_level->pet_scale . "\n";
        echo $hf_start . 'CompanionHealth_89_294A6BE7439072AE9F934CAA127D8D83,0,,' . $mh_level->companion_scale . "\n";
        echo $hf_start . 'DropWeightCommonScalar_21_59A2FB124E32B955768A7B9D93C25A99,0,,' . $mh_level->white_scale . "\n";
        echo $hf_start . 'DropWeightUncommonScalar_25_809615334E7F0DB3B8712DAC221015C3,0,,' . $mh_level->green_scale . "\n";
        echo $hf_start . 'DropWeightRareScalar_27_A09CF5314C51796896A83EA0806C7520,0,,' . $mh_level->blue_scale . "\n";
        echo $hf_start . 'DropWeightVeryRareScalar_29_F2CA570046CD50A7C514EDB0AE1BE591,0,,' . $mh_level->purple_scale . "\n";
        echo $hf_start . 'DropWeightLegendaryScalar_31_D9DA03C54065EA981BE218B11942C24E,0,,' . $mh_level->orange_scale . "\n";
        echo $hf_start . 'DamageScalarActionSkill_60_39AF483140740A38FC71BA897155CBFF,0,,' . $mh_level->dam_as . "\n";
        echo $hf_start . 'DamageScalarMelee_67_9948929F4FF34364CED2EAB51A881946,0,,' . $mh_level->dam_melee . "\n";
        echo $hf_start . 'DamageScalarSlide_68_B48D0E3A4DF57196839BB58D5AE3E638,0,,' . $mh_level->dam_slide . "\n";
        echo $hf_start . 'DamageScalarSlam_69_15DB6EDC4CCA52620BF25398CFFD9B26,0,,' . $mh_level->dam_slam . "\n";
        echo $hf_start . 'DamageScalarPet_72_0DD7977D44C4A71D0A6B56B7884E023C,0,,' . $mh_level->dam_pet . "\n";
        echo $hf_start . 'DamageScalarEnviornmental_111_E2A582AA47FC000789FC68BBD31D2CFC,0,,' . $mh_level->dam_env . "\n";
        echo $hf_start . 'DamageScalarPassive_115_6A30229E4CC04F751ED01CB64A71880F,0,,' . $mh_level->dam_passive . "\n";
        echo $hf_start . 'DamageDealtScalarVehicles_103_5739171948322B35CDA36487F78AF0CE,0,,' . $mh_level->dam_veh_dealt . "\n";
        echo $hf_start . 'DamageTakenScalarVehicles_104_B75AB4EC482624FDEAAF31B0FA369A77,0,,' . $mh_level->dam_veh_taken . "\n";
        echo $hf_start . 'DamageScalarGear_119_9FC89117424C6619F2CA958FA2842FC2,0,,' . $mh_level->dam_gear . "\n";
        echo $hf_start . 'DropNumberChanceSimpleScalar_40_115637764B3918F01E6FAFADDC005388,0,,' . $mh_level->dropnum . "\n";
        echo $hf_start . 'DropEridiumChanceSimpleScalar_41_E89AD7E9473FDF3CBED395BA6641FA68,0,,' . $mh_level->eridium . "\n";
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
$page->add_js('mayhem.js', 2);
$page->add_onload('updatelink();');
$page->add_changelog('Jun 24, 2021', 'Initial release');
$page->add_changelog('Jun 25, 2021', 'Added note about M11 probably using M10 stats');
$page->add_changelog('Jun 28, 2021', 'Removed M11 scaling parameters, since it just uses M10');
$page->apoc_header();

?>

<noscript><h1>Note: Alas, this page does require Javascript.  Sorry!</h1></noscript>

<p>
This is a web app to generate <a href="http://borderlandsmodding.com/bl3/">BL3 Hotfix Mods</a>
to alter characteristics of BL3's <a href="https://borderlands.fandom.com/wiki/Mayhem_Mode">Mayhem Mode</a>.
Click around to change whatever you like, and when you're ready, hit the
<tt>Generate Modfile</tt> button to download the
<a href="http://borderlandsmodding.com/bl3-running-mods/">B3HM-compatible mod file</a>
containing your config.  Choose <tt>Add Local Path</tt> from B3HM's web UI to
add the downloaded file to your mod list.  (This page does <i>not</i> support
adding to B3HM via <tt>Add URL</tt>.)  As you change options, the app will generate
a unique URL to store your config.  Bookmark the URL (or look inside the downloaded
mod file) to return to the config to make changes in the future.
</p>

<p>
Sourcecode for this page can be found at <a href="https://github.com/apocalyptech/bl3mayhem/">github.com/apocalyptech/bl3mayhem</a>.
</p>

<table class="control_area">

<tr>
<td colspan="3">
<div class="modlink">
<b>URL to this configuration:</b> <a href="<?php echo $BASE_URL; ?>" id="modlink_a"><?php echo $BASE_URL; ?></a>
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

