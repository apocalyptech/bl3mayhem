
function updatelink()
{
    // Dict that we'll JSONify+compress+base64 for the link
    var linkdata = {'v': 2};

    // Get our active mods, per level
    var active_mods = [[],[],[],[],[]]
    var elements;
    var parts;
    var mod_type;
    var mod_name;
    for (var section=0; section<5; section++)
    {
        var elements = document.getElementsByClassName('modifier_' + section);
        for (var i=0; i < elements.length; i++)
        {
            parts = elements[i].id.split('_');
            mod_type = parseInt(parts[0]);
            mod_name = parts.slice(1).join('_');
            if (elements[i].checked)
            {
                active_mods[section].push(i);
            }
        }
    }
    linkdata['p'] = active_mods;

    // Now our selections for level configurations
    var levels = [];
    for (var level=0; level<11; level++)
    {
        var new_level = [];
        elements = document.getElementsByClassName('mayhem_' + (level+1) + '_pool');
        for (var i=0; i < elements.length; i++)
        {
            selected_value = parseInt(elements[i].options[elements[i].selectedIndex].value);
            if (selected_value >= 0)
            {
                new_level.push(selected_value);
            }
        }
        levels.push(new_level);
    }
    linkdata['l'] = levels;

    // Now scaling info
    var scaling = [];
    var scale_vars = ['enemy', 'xp', 'cash', 'loot', 'pets', 'companions',
        'white', 'green', 'blue', 'purple', 'orange',
        'dam_as', 'dam_melee', 'dam_slide', 'dam_slam', 'dam_pet',
        'dam_env', 'dam_passive', 'dam_veh_dealt', 'dam_veh_taken', 'dam_gear',
        'dropnum', 'eridium',
    ];
    for (var level=0; level<10; level++)
    {
        mayhem_label = 'mayhem_' + (level+1) + '_';
        scales = [];
        for (var i=0; i<scale_vars.length; i++)
        {
            cur_element = document.getElementById(mayhem_label + scale_vars[i]);
            prev_element = document.getElementById(mayhem_label + scale_vars[i] + '_prev');

            // Check for number validity, since these are user-inputtable.  We'll
            // keep track of "previous" values and overwrite using them, if we
            // encounter a number we don't know how to deal with.
            cur_val = parseFloat(cur_element.value);
            if (Number.isNaN(cur_val))
            {
                prev_val = parseFloat(prev_element.value);
                if (Number.isNaN(prev_val))
                {
                    cur_val = 0;
                }
                else
                {
                    cur_val = prev_val;
                }
                cur_element.value = cur_val;
            }
            prev_element.value = cur_val;
            scales.push(cur_val);
        }
        scaling.push(scales);
    }
    linkdata['s'] = scaling;

    // Generate the link
    var link = document.getElementById('modlink_a');
    jsond = JSON.stringify(linkdata);
    //console.log(jsond);
    lzd = LZString.compressToEncodedURIComponent(jsond);
    link.href = 'https://apocalyptech.com/games/bl3-mayhem/index.php?config=' + lzd;
    if (link.href.length > 90)
    {
        link.innerHTML = link.href.substring(0, 80) + '...' + link.href.substring(link.href.length-10);
    }
    else
    {
        link.innerHTML = link.href;
    }

    // Also inject into our generation button
    element = document.getElementById('generation_config');
    element.value = lzd;

}

function restyleselect(element)
{
    // Not exactly portable here, but it happens to work for this specific case.
    cur_classes = element.className.split(' ')
    element.className = cur_classes[0] + ' ' + cur_classes[1] + ' ' + element.options[element.selectedIndex].className;
}

