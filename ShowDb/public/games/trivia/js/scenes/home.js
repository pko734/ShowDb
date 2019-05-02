var HomeScene = new Phaser.Class({

    Extends: Phaser.Scene,

    initialize:

    function HomeScene ()
    {
        Phaser.Scene.call(this, {key: 'homeScene'});
    },

    init: function(data) {
        this.round = data.round || 1;
        this.roundLength = data.roundLength || 5;
        this.numCorrect = data.numCorrect || 0;
        this.score = data.score || 0;
        this.timeBonus = data.timeBonus || 0;
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
        for(let i = (this.round - 1) * this.roundLength; i < (((this.round - 1) * this.roundLength) + this.roundLength); i++) {
            if(!questions[i]) {
                break;
            }
            if(questions[i].audio) {
                this.load.audio(
                    'question' + i + '_audio', 
                    [
                        questions[i].audio.replace(/\.mp3/, '.ogg'),
                        questions[i].audio                        
                    ]
                );
            }
            if(questions[i].image) {
                this.load.image('question' + i + '_image', questions[i].image);
            }
        }
        this.load.start();
    },

    createBackground: function() {
        let bg = this.add.sprite(0, 0, 'bg' + (((this.round - 1) % 20) + 1)).setOrigin(0, 0);

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
        startBtn.on('pointerup', function(pointer) {
            this.scale.startFullscreen();
            this.scene.start('gameScene', {
                round: this.round, 
                roundLength: this.roundLength,
                numCorrect: this.numCorrect,
                score: this.score,
                timeBonus: this.timeBonus
            });
        }, this);
        let startTxt = this.add.text(0, 0, 'Round ' + this.round, {
            fill: '#000',
            align: 'center',
            font: '64px Open Sans'
        });
        startTxt.setOrigin(0.5);
        this.startCon = this.add.container(
            this.sys.game.config.width / 2, 
            this.sys.game.config.height / 2, 
            [startBtn, startTxt]
        );
        let bannerTxt = this.add.text(            
            this.sys.game.config.width / 2 + 40, 
            100,
            'Avett Trivia Challenge',
            {
                font: '64px Open Sans',                
            }
        );
        bannerTxt.setOrigin(0.5);
        bannerTxt.setShadow(5, 5, 'rgba(0, 0, 0, 0.9)');

        let logo = this.add.sprite(bannerTxt.x - (bannerTxt.width / 2) - 45, 100, 'dblogo');
        logo.setOrigin(0.5, 0.5);
        logo.setScale(0.8);
    }
});

