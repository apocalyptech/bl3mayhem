<?php
// File generated by gen_mayhem_php.py in Apocalyptech's dataprocessing dir

// Easy Main Object
$modset_easy = new ModSet('Easy',
    '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_EAsy.ModSet_Mayhem2_EAsy',
    0);

// Lootsplosion
$lootsplosion = new Modifier('lootsplosion',
    'Lootsplosion',
    'Easy',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/PartyTime/Ability_Mayhem2_PartyTime.Ability_Mayhem2_PartyTime_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('PartyTime'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_PartyTime.ModUiStat_Mayhem2_Players_PartyTime');

// Big Kick Energy
$big_kick_energy = new Modifier('big_kick_energy',
    'Big Kick Energy',
    'Easy',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/AimForTheSky/Ability_Mayhem2_AimForTheSky.Ability_Mayhem2_AimForTheSky_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('AimForTheSky'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_AimForTheSky.ModUiStat_Mayhem2_Players_AimForTheSky');

// More Than Okay Boomer
$more_than_okay_boomer = new Modifier('more_than_okay_boomer',
    'More Than Okay Boomer',
    'Easy',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/RoidRage/Ability_Mayhem2_RoidRage.Ability_Mayhem2_RoidRage_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('RoidRage'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_RoidRage.ModUiStat_Mayhem2_Players_RoidRage');

// Speed Demon
$speed_demon = new Modifier('speed_demon',
    'Speed Demon',
    'Easy',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/SoulStealer/Ability_Mayhem2_SoulStealer.Ability_Mayhem2_SoulStealer_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('SoulStealer'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_SoulStealer.ModUiStat_Mayhem2_Players_SoulStealer');

// Galaxy Brain
$galaxy_brain = new Modifier('galaxy_brain',
    'Galaxy Brain',
    'Easy',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Shared/Bighetti/Ability_Mayhem2_Bighetti.Ability_Mayhem2_Bighetti_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Shared/Bighetti/Ability_Mayhem2_Bighetti.Ability_Mayhem2_Bighetti_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('Bighetti'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Shared/ModUiStat_Mayhem2_Shared_Bighetti.ModUiStat_Mayhem2_Shared_Bighetti');

// Slayer
$slayer = new Modifier('slayer',
    'Slayer',
    'Easy',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/FinishThem/Ability_Mayhem2_FinishThem.Ability_Mayhem2_FinishThem_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('FinishThem'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_FinishThem.ModUiStat_Mayhem2_Enemies_FinishThem');

// Medium Main Object
$modset_medium = new ModSet('Medium',
    '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_Medium.ModSet_Mayhem2_Medium',
    1);

// Floor is Lava
$floor_is_lava = new Modifier('floor_is_lava',
    'Floor is Lava',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/FloorIsLava/Ability_Mayhem2_FLoorIsLava.Ability_Mayhem2_FloorIsLava_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('FloorIsLava'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_FloorIsLava.ModUiStat_Mayhem2_Players_FloorIsLava');

// Freeze Tag
$freeze_tag = new Modifier('freeze_tag',
    'Freeze Tag',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/FrozenPulse/Ability_Mayhem2_FrozenPulse.Ability_Mayhem2_FrozenPulse_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('FrozenPulse'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_FrozenPulse.ModUiStat_Mayhem2_Enemies_FrozenPulse');

// Mob Mentality
$mob_mentality = new Modifier('mob_mentality',
    'Mob Mentality',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/Rally/Ability_Mayhem2_Rally.Ability_Mayhem2_Rally_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('Rally', 'ChainGang'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_Rally.ModUiStat_Mayhem2_Enemies_Rally');

// Pain Tolerance
$pain_tolerance = new Modifier('pain_tolerance',
    'Pain Tolerance',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/OlSwitcheroo/Ability_Mayhem2_OlSwitcheroo.Ability_Mayhem2_OlSwitcheroo_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('OlSwitcheroo', 'BegoneDot'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_OlSwitcheroo.ModUiStat_Mayhem2_Enemies_OlSwitcheroo');

// Acid Reign
$acid_reign = new Modifier('acid_reign',
    'Acid Reign',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ElementalInfusion/Ability_Mayhem2_ElementalInfusion_Corrosive.Ability_Mayhem2_ElementalInfusion_Corrosive_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    0.4,
    array('ElementalInfusion'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ElementalInfusion_Corrosive.ModUiStat_Mayhem2_Enemies_ElementalInfusion_Corrosive');

// Chilling Them Softly
$chilling_them_softly = new Modifier('chilling_them_softly',
    'Chilling Them Softly',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ElementalInfusion/Ability_Mayhem2_ElementalInfusion_Cryo.Ability_Mayhem2_ElementalInfusion_Cryo_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    0.4,
    array('ElementalInfusion'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ElementalInfusion_Cryo.ModUiStat_Mayhem2_Enemies_ElementalInfusion_Cryo');

// Charred Mode
$charred_mode = new Modifier('charred_mode',
    'Charred Mode',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ElementalInfusion/Ability_Mayhem2_ElementalInfusion_Fire.Ability_Mayhem2_ElementalInfusion_Fire_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    0.4,
    array('ElementalInfusion'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ElementalInfusion_Fire.ModUiStat_Mayhem2_Enemies_ElementalInfusion_Fire');

// Totally Radical
$totally_radical = new Modifier('totally_radical',
    'Totally Radical',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ElementalInfusion/Ability_Mayhem2_ElementalInfusion_Radiation.Ability_Mayhem2_ElementalInfusion_Radiation_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    0.4,
    array('ElementalInfusion'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ElementalInfusion_Radiation.ModUiStat_Mayhem2_Enemies_ElementalInfusion_Radiation');

// High Voltage
$high_voltage = new Modifier('high_voltage',
    'High Voltage',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ElementalInfusion/Ability_Mayhem2_ElementalInfusion_Shock.Ability_Mayhem2_ElementalInfusion_Shock_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    0.4,
    array('ElementalInfusion'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ElementalInfusion_Shock.ModUiStat_Mayhem2_Enemies_ElementalInfusion_Shock');

// Healy Avenger
$healy_avenger = new Modifier('healy_avenger',
    'Healy Avenger',
    'Medium',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/HealNo/Ability_Mayhem2_HealNo.Ability_Mayhem2_HealNo_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('HealNo'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_HealNo.ModUiStat_Mayhem2_Enemies_HealNo');

// Hard Main Object
$modset_hard = new ModSet('Hard',
    '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_Hard.ModSet_Mayhem2_Hard',
    2);

// Chain Gang
$chain_gang = new Modifier('chain_gang',
    'Chain Gang',
    'Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ChainGang/Ability_Mayhem2_ChainGang.Ability_Mayhem2_ChainGang_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('ChainGang', 'Rally'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ChainGang.ModUiStat_Mayhem2_Enemies_ChainGang');

// Laser Fare
$laser_fare = new Modifier('laser_fare',
    'Laser Fare',
    'Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ArcaneEnchanter/Ability_Mayhem2_ArcaneEnchanter.Ability_Mayhem2_ArcaneEnchanter_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('ArcaneEnchanter'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ArcaneEnchanter.ModUiStat_Mayhem2_Enemies_ArcaneEnchanter');

// Drone Ranger
$drone_ranger = new Modifier('drone_ranger',
    'Drone Ranger',
    'Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/DroneBuddy/Ability_Mayhem2_DroneBuddy.Ability_Mayhem2_DroneBuddy_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('DroneBuddy', 'PriorityTarget'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_DroneBuddy.ModUiStat_Mayhem2_Enemies_DroneBuddy');

// Pool Party
$pool_party = new Modifier('pool_party',
    'Pool Party',
    'Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/EleBreaker/Ability_Mayhem2_Ele_Breaker.Ability_Mayhem2_Ele_Breaker_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('EleBreaker'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_Ele_Breaker.ModUiStat_Mayhem2_Enemies_Ele_Breaker');

// Boundary Issues
$boundary_issues = new Modifier('boundary_issues',
    'Boundary Issues',
    'Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/StayBack/Ability_Mayhem2_StayBack.Ability_Mayhem2_StayBack_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('StayBack'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_StayBack.ModUiStat_Mayhem2_Players_StayBack');

// Ticked Off
$ticked_off = new Modifier('ticked_off',
    'Ticked Off',
    'Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/BegoneDot/Ability_Mayhem2_BegoneDot.Ability_Mayhem2_BegoneDot_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('BegoneDot', 'OlSwitcheroo', 'Sharpshot'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_BegoneDot.ModUiStat_Mayhem2_Enemies_BegoneDot');

// Very Hard Main Object
$modset_very_hard = new ModSet('Very Hard',
    '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_VeryHard.ModSet_Mayhem2_VeryHard',
    3);

// Post Mortem
$post_mortem = new Modifier('post_mortem',
    'Post Mortem',
    'Very Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/DeathFromBeyond/Ability_Mayhem2_DeathFromBeyond.Ability_Mayhem2_DeathFromBeyond_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('DeathFromBeyond'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_DeathFromBeyond.ModUiStat_Mayhem2_Enemies_DeathFromBeyond');

// Rogue Lite
$rogue_lite = new Modifier('rogue_lite',
    'Rogue Lite',
    'Very Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/RogueLite/Ability_Mayhem2_RogueLite.Ability_Mayhem2_RogueLite_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('RogueLite'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_RogueLite.ModUiStat_Mayhem2_Players_RogueLite');

// Not the Face
$not_the_face = new Modifier('not_the_face',
    'Not the Face',
    'Very Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/CriticalFailure/Ability_Mayhem2_CritFail.Ability_Mayhem2_CritFail_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('CritFail', 'Sharpshot'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_CriticalFailure.ModUiStat_Mayhem2_Players_CriticalFailure');

// Holy Crit
$holy_crit = new Modifier('holy_crit',
    'Holy Crit',
    'Very Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Player/Sharpshot/Ability_Mayhem2_Sharpshot.Ability_Mayhem2_Sharpshot_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_OnTeam_Players.TargetResolution_OnTeam_Players'),
    ),
    1.0,
    array('Sharpshot', 'CritFail', 'BegoneDot'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Players/ModUiStat_Mayhem2_Players_Sharpshot.ModUiStat_Mayhem2_Players_Sharpshot');

// Buddy System
$buddy_system = new Modifier('buddy_system',
    'Buddy System',
    'Very Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/PriorityTarget/Ability_Mayhem2_PriorityTarget.Ability_Mayhem2_PriorityTarget_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('PriorityTarget', 'DroneBuddy'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_PriorityTarget.ModUiStat_Mayhem2_Enemies_PriorityTarget');

// Dazed and Infused
$dazed_and_infused = new Modifier('dazed_and_infused',
    'Dazed and Infused',
    'Very Hard',
    array(
        new Ability('/Game/PatchDLC/Mayhem2/Abilities/Enemy/ElementalInfusion/Ability_Mayhem2_ElementalInfusion_All.Ability_Mayhem2_ElementalInfusion_All_C',
            '/Game/GameData/Modifiers/TargetResolution/TargetResolution_Enemies.TargetResolution_Enemies'),
    ),
    1.0,
    array('ElementalInfusion'),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_Enemies_ElementalInfusion_All.ModUiStat_Mayhem2_Enemies_ElementalInfusion_All');

// Mayhem 11 Main Object
$modset_mayhem_11 = new ModSet('Mayhem 11',
    '/Game/PatchDLC/Mayhem2/ModifierSets/ModSet_Mayhem2_Mayhem11.ModSet_Mayhem2_Mayhem11',
    4);

// (no modifier)
$mayhem_11 = new Modifier('mayhem_11',
    '(no modifier)',
    'Mayhem 11',
    array(
        new Ability('None',
            'None'),
    ),
    1.0,
    array(),
    '/Game/PatchDLC/Mayhem2/ModifierSets/UI/Enemies/ModUiStat_Mayhem2_ToEleven.ModUiStat_Mayhem2_ToEleven');

$all_modifiers = array(
    $lootsplosion,
    $big_kick_energy,
    $more_than_okay_boomer,
    $speed_demon,
    $galaxy_brain,
    $slayer,
    $floor_is_lava,
    $freeze_tag,
    $mob_mentality,
    $pain_tolerance,
    $acid_reign,
    $chilling_them_softly,
    $charred_mode,
    $totally_radical,
    $high_voltage,
    $healy_avenger,
    $chain_gang,
    $laser_fare,
    $drone_ranger,
    $pool_party,
    $boundary_issues,
    $ticked_off,
    $post_mortem,
    $rogue_lite,
    $not_the_face,
    $holy_crit,
    $buddy_system,
    $dazed_and_infused,
    $mayhem_11,
    );

$all_modsets = array(
    $modset_easy,
    $modset_medium,
    $modset_hard,
    $modset_very_hard,
    $modset_mayhem_11,
    );

$mayhem_levels = array(
    new MayhemLevel(1,
        2.0, 0.2, 0.2, 1.0, 1.625, 1.3125,
        1.0, 100.0, 100.0, 50.0, 25.0,
        1.6, 1.2, 1.4, 1.4, 2.0,
        1.66, 1.1, 1.2, 2.25, 1.66,
        -0.0025, 0.2,
        array(
            $modset_easy,
            )),
    new MayhemLevel(2,
        4.0, 0.4, 0.4, 3.0, 2.25, 1.625,
        1.0, 100.0, 100.0, 50.0, 35.0,
        2.2, 1.4, 1.8, 1.8, 3.0,
        2.32, 1.2, 1.4, 3.5, 2.32,
        0.0, 0.4,
        array(
            $modset_easy,
            $modset_medium,
            )),
    new MayhemLevel(3,
        6.0, 0.6, 0.6, 5.0, 2.875, 1.9375,
        1.0, 100.0, 125.0, 100.0, 60.0,
        2.8, 1.6, 2.2, 2.2, 4.0,
        2.98, 1.3, 1.6, 4.75, 2.98,
        0.0, 0.6,
        array(
            $modset_easy,
            $modset_medium,
            $modset_medium,
            )),
    new MayhemLevel(4,
        8.0, 0.8, 0.8, 7.5, 3.5, 2.25,
        1.0, 75.0, 125.0, 125.0, 70.0,
        3.4, 1.8, 2.6, 2.6, 5.0,
        3.64, 1.4, 1.8, 6.0, 3.64,
        0.0, 0.8,
        array(
            $modset_easy,
            $modset_hard,
            )),
    new MayhemLevel(5,
        15.0, 1.0, 1.0, 10.0, 4.125, 2.5625,
        1.0, 75.0, 100.0, 125.0, 75.0,
        5.5, 2.5, 4.0, 4.0, 8.5,
        5.95, 1.75, 2.5, 7.25, 5.95,
        0.0, 1.0,
        array(
            $modset_easy,
            $modset_medium,
            $modset_hard,
            )),
    new MayhemLevel(6,
        30.0, 1.2, 1.2, 13.0, 4.75, 2.875,
        1.0, 75.0, 100.0, 150.0, 90.0,
        10.0, 4.0, 7.0, 7.0, 16.0,
        10.9, 2.05, 4.0, 8.5, 10.9,
        0.0, 1.2,
        array(
            $modset_easy,
            $modset_medium,
            $modset_medium,
            $modset_hard,
            )),
    new MayhemLevel(7,
        45.0, 1.4, 1.4, 16.0, 5.375, 3.1875,
        1.0, 75.0, 75.0, 200.0, 100.0,
        14.5, 5.5, 10.0, 10.0, 23.5,
        15.85, 2.6, 5.5, 9.75, 15.85,
        0.0, 1.4,
        array(
            $modset_easy,
            $modset_hard,
            $modset_hard,
            )),
    new MayhemLevel(8,
        60.0, 1.6, 1.6, 19.0, 6.0, 3.5,
        1.0, 50.0, 75.0, 225.0, 110.0,
        19.0, 7.0, 13.0, 13.0, 31.0,
        20.8, 3.1, 7.0, 11.0, 20.8,
        0.0, 1.6,
        array(
            $modset_easy,
            $modset_very_hard,
            )),
    new MayhemLevel(9,
        80.0, 1.8, 1.8, 22.0, 6.625, 3.8125,
        1.0, 50.0, 75.0, 250.0, 125.0,
        25.0, 9.0, 17.0, 17.0, 41.0,
        27.4, 3.8, 9.0, 12.25, 27.4,
        0.0, 1.8,
        array(
            $modset_easy,
            $modset_medium,
            $modset_very_hard,
            )),
    new MayhemLevel(10,
        100.0, 2.0, 2.0, 25.0, 7.25, 4.125,
        1.0, 50.0, 50.0, 250.0, 150.0,
        31.0, 16.0, 21.0, 21.0, 51.0,
        34.0, 4.5, 11.0, 13.5, 34.0,
        0.0, 2.0,
        array(
            $modset_easy,
            $modset_medium,
            $modset_hard,
            $modset_very_hard,
            )),
    new MayhemLevel(11,
        100.0, 1.0, 1.0, 12.5, 7.25, 4.125,
        1.0, 100.0, 100.0, 125.0, 75.0,
        31.0, 16.0, 21.0, 21.0, 51.0,
        34.0, 4.5, 11.0, 13.5, 34.0,
        0.0, 1.0,
        array(
            $modset_mayhem_11,
            )),
    );

$default_config = array(
    'v' => 1,
    'p' => array(
        array(0, 1, 2, 3, 4, 5),
        array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15),
        array(16, 17, 18, 19, 20, 21),
        array(22, 23, 24, 25, 26, 27),
        array(28),
        ),
    'l' => array(
        array($modset_easy->index),
        array($modset_easy->index, $modset_medium->index),
        array($modset_easy->index, $modset_medium->index, $modset_medium->index),
        array($modset_easy->index, $modset_hard->index),
        array($modset_easy->index, $modset_medium->index, $modset_hard->index),
        array($modset_easy->index, $modset_medium->index, $modset_medium->index, $modset_hard->index),
        array($modset_easy->index, $modset_hard->index, $modset_hard->index),
        array($modset_easy->index, $modset_very_hard->index),
        array($modset_easy->index, $modset_medium->index, $modset_very_hard->index),
        array($modset_easy->index, $modset_medium->index, $modset_hard->index, $modset_very_hard->index),
        array($modset_mayhem_11->index),
        ),
    's' => array(
        array(2.0, 0.2, 0.2, 1.0, 1.625, 1.3125, 1.0, 100.0, 100.0, 50.0, 25.0, 1.6, 1.2, 1.4, 1.4, 2.0, 1.66, 1.1, 1.2, 2.25, 1.66, -0.0025, 0.2),
        array(4.0, 0.4, 0.4, 3.0, 2.25, 1.625, 1.0, 100.0, 100.0, 50.0, 35.0, 2.2, 1.4, 1.8, 1.8, 3.0, 2.32, 1.2, 1.4, 3.5, 2.32, 0.0, 0.4),
        array(6.0, 0.6, 0.6, 5.0, 2.875, 1.9375, 1.0, 100.0, 125.0, 100.0, 60.0, 2.8, 1.6, 2.2, 2.2, 4.0, 2.98, 1.3, 1.6, 4.75, 2.98, 0.0, 0.6),
        array(8.0, 0.8, 0.8, 7.5, 3.5, 2.25, 1.0, 75.0, 125.0, 125.0, 70.0, 3.4, 1.8, 2.6, 2.6, 5.0, 3.64, 1.4, 1.8, 6.0, 3.64, 0.0, 0.8),
        array(15.0, 1.0, 1.0, 10.0, 4.125, 2.5625, 1.0, 75.0, 100.0, 125.0, 75.0, 5.5, 2.5, 4.0, 4.0, 8.5, 5.95, 1.75, 2.5, 7.25, 5.95, 0.0, 1.0),
        array(30.0, 1.2, 1.2, 13.0, 4.75, 2.875, 1.0, 75.0, 100.0, 150.0, 90.0, 10.0, 4.0, 7.0, 7.0, 16.0, 10.9, 2.05, 4.0, 8.5, 10.9, 0.0, 1.2),
        array(45.0, 1.4, 1.4, 16.0, 5.375, 3.1875, 1.0, 75.0, 75.0, 200.0, 100.0, 14.5, 5.5, 10.0, 10.0, 23.5, 15.85, 2.6, 5.5, 9.75, 15.85, 0.0, 1.4),
        array(60.0, 1.6, 1.6, 19.0, 6.0, 3.5, 1.0, 50.0, 75.0, 225.0, 110.0, 19.0, 7.0, 13.0, 13.0, 31.0, 20.8, 3.1, 7.0, 11.0, 20.8, 0.0, 1.6),
        array(80.0, 1.8, 1.8, 22.0, 6.625, 3.8125, 1.0, 50.0, 75.0, 250.0, 125.0, 25.0, 9.0, 17.0, 17.0, 41.0, 27.4, 3.8, 9.0, 12.25, 27.4, 0.0, 1.8),
        array(100.0, 2.0, 2.0, 25.0, 7.25, 4.125, 1.0, 50.0, 50.0, 250.0, 150.0, 31.0, 16.0, 21.0, 21.0, 51.0, 34.0, 4.5, 11.0, 13.5, 34.0, 0.0, 2.0),
        array(100.0, 1.0, 1.0, 12.5, 7.25, 4.125, 1.0, 100.0, 100.0, 125.0, 75.0, 31.0, 16.0, 21.0, 21.0, 51.0, 34.0, 4.5, 11.0, 13.5, 34.0, 0.0, 1.0),
        ),
    );

