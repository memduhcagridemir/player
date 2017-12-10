var Player = function(playlist) {
    this.index = 0;
    this.playlist = playlist;

    track.innerHTML = "1. " + playlist[0].title;
};

Player.prototype = {
    /**
     * Play a song in the playlist.
     * @param  {Number} index Index of the song in the playlist (leave empty to play the first or current).
     */
    play: function(index) {
        var self = this;
        var sound;

        index = typeof index === 'number' ? index : self.index;
        var data = self.playlist[index];

        if (data.howl) {
            sound = data.howl;
        } else {
            sound = data.howl = new Howl({
                src: [data.file],
                html5: true,
                onplay: function() {
                    duration.innerHTML = self.formatTime(Math.round(sound.duration()));
                    requestAnimationFrame(self.step.bind(self));
                },
                onend: function() {
                    self.skip('right');
                }
            });
        }

        sound.play();
        track.innerHTML = (this.index + 1) + ". " + data.title;
        self.index = index;

        playBtn.style.display = 'none';
        pauseBtn.style.display = 'inline-block';
    },

    /**
     * Pause the currently playing track.
     */
    pause: function() {
        var self = this;

        var sound = self.playlist[self.index].howl;
        sound.pause();

        playBtn.style.display = 'inline-block';
        pauseBtn.style.display = 'none';
    },

    /**
     * Skip to the next or previous track.
     * @param  {String} direction 'next' or 'prev'.
     */
    skip: function(direction) {
        var self = this;

        var index = 0;
        if (direction === 'prev') {
            index = self.index - 1;
            if (index < 0) {
                index = self.playlist.length - 1;
            }
        } else {
            index = self.index + 1;
            if (index >= self.playlist.length) {
                index = 0;
            }
        }

        self.skipTo(index);
    },

    /**
     * Skip to a specific track based on its playlist index.
     * @param  {Number} index Index in the playlist.
     */
    skipTo: function(index) {
        var self = this;

        // Stop the current track.
        if (self.playlist[self.index].howl) {
            self.playlist[self.index].howl.stop();
        }

        // Reset progress.
        progress.style.width = '0%';

        // Play the new track.
        self.play(index);
    },

    /**
     * Set the volume and update the volume slider display.
     * @param  {Number} val Volume between 0 and 1.
     */
    volume: function(val) {
        var self = this;

        // Update the global volume (affecting all Howls).
        Howler.volume(val);
    },

    /**
     * Seek to a new position in the currently playing track.
     * @param  {Number} per Percentage through the song to skip.
     */
    seek: function(per) {
        var self = this;

        // Get the Howl we want to manipulate.
        var sound = self.playlist[self.index].howl;

        // Convert the percent into a seek position.
        if (sound.playing()) {
            sound.seek(sound.duration() * per);
        }
    },

    /**
     * The step called within requestAnimationFrame to update the playback position.
     */
    step: function() {
        var self = this;

        // Get the Howl we want to manipulate.
        var sound = self.playlist[self.index].howl;

        // Determine our current seek position.
        var seek = sound.seek() || 0;
        timer.innerHTML = self.formatTime(Math.round(seek));
        progress.style.width = (((seek / sound.duration()) * 100) || 0) + '%';

        // If the sound is still playing, continue stepping.
        if (sound.playing()) {
            requestAnimationFrame(self.step.bind(self));
        }
    },

    /**
     * Format the time from seconds to M:SS.
     * @param  {Number} secs Seconds to format.
     * @return {String}      Formatted time.
     */
    formatTime: function(secs) {
        var minutes = Math.floor(secs / 60) || 0;
        var seconds = (secs - minutes * 60) || 0;

        return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    }
};