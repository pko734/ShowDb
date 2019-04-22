var HomeScene = new Phaser.Class({

    Extends: Phaser.Scene,

    initialize:

    function HomeScene ()
    {
        Phaser.Scene.call(this, {key: 'homeScene'});
    },

    create: function() {
        this.preloadQuestionAssets();
        this.createBackground();
        this.createStartBtn();
    },

    preloadQuestionAssets()
    {        
        let questions = this.cache.json.get('questions');
        this.load.setCORS('anonymous');
        for(q in questions) {
            if(questions[q].audio) {
                this.load.audio(
                    'question' + q + '_audio', 
                    [
                        questions[q].audio.replace(/\.mp3/, '.ogg'),
                        questions[q].audio                        
                    ]
                );
            }
        }
        this.load.start();
    },

    createBackground: function() {
        let bg = this.add.sprite(0, 0, 'bg').setOrigin(0, 0);
        bg.displayWidth = this.sys.game.config.width;
        bg.displayHeight = this.sys.game.config.height;
    },

    createStartBtn: function() {
        let startBtn = this.add.sprite(
            0, 
            0, 
            'greySheet',
            'grey_button00.png'
        );
        startBtn.setInteractive();
        startBtn.setScale(3);
        startBtn.on('pointerdown', function(pointer) {
            this.scene.start('gameScene');
        }, this);
        let startTxt = this.add.text(0, 0, 'Start', {
            fill: '#000',
            align: 'center',
            font: '64px Open Sans'
        });
        startTxt.setOrigin(0.5);
        this.startCon = this.add.container(
            375, 
            500, 
            [startBtn, startTxt]
        );

    }
});

