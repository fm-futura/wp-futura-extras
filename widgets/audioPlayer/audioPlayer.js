jQuery(document).ready(function ($) {

    jQuery('.audioPlayer').each(function () {
        audioPlayer(jQuery(this));
    });
});

function audioPlayer($player) {

    var container = $player;
    var play = container.find('.mdi-play-circle-outline');
    var pause = container.find('.mdi-pause-circle-outline');
    var mute = container.find('.mdi-volume-high');
    var muted = container.find('.mdi-volume-off');
    var volume = container.find('.volumen .input_container input');
    var seek = container.find('.controls_container.track input');
    var song = new Audio();
    var duration = song.duration;

    song.preload = 'none';
    if (song.canPlayType('audio/mpeg;')) {
        song.type = 'audio/mpeg';
        song.src = container.data('audio-mp3');
    } else {
        song.type = 'audio/ogg';
        song.src = container.data('audio-ogg');
    }


    jQuery(song).on('loadeddata', function () {
        duration = song.duration;

        song.addEventListener('timeupdate', function () {
            var curtime = parseInt(song.currentTime, 10);
            seek.val(curtime);
        });
        /******************** SEEK ********************/
        seek.bind('mousedown', function () {
            song.removeEventListener('timeupdate');
            console.log('mousedown');
        });
        seek.bind('mouseup', function () {
            song.addEventListener('timeupdate', function () {
                var curtime = parseInt(song.currentTime, 10);
                seek.val(curtime);
            });
            console.log('mouseup');
        });
        seek.bind("change", function () {
            if (jQuery(this).val() >= song.buffered.end(0)) {
                song.currentTime = song.buffered.end(0);
                jQuery(this).val(song.buffered.end(0));
            } else {
                song.currentTime = parseInt(jQuery(this).val(), 10);
            }
            seek.attr("max", duration);
        });
        /******************** SEEK ********************/
    });

    /******************** PLAY ********************/
    play.on('click', function (e) {
        e.preventDefault();
        audioTest = song;
        song.play();
        seek.attr('max', duration);
        volume.attr('max', 100);
        jQuery(this).parent('.mdi-container').addClass('active');
    });
    /******************** PAUSE ********************/
    pause.on('click', function (e) {
        e.preventDefault();
        song.pause();
        jQuery(this).parent('.mdi-container').removeClass('active');
    });
    /******************** PAUSE ********************/
    /******************** MUTE ********************/
    mute.on('click', function (e) {
        e.preventDefault();
        song.volume = 0;
        jQuery(this).parent('.mdi-container').addClass('muted');
    });
    muted.on('click', function (e) {
        e.preventDefault();
        song.volume = 1;
        jQuery(this).parent('.mdi-container').removeClass('muted');
    });
    /******************** MUTE ********************/

    volume.bind("change", function () {
        song.volume = jQuery(this).val() / 100;
        volume.attr("max", 100);
    })
}
