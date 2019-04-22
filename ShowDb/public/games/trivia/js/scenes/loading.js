var LoadingScene = new Phaser.Class({

    Extends: Phaser.Scene,

    initialize:

    function LoadingScene ()
    {
        Phaser.Scene.call(this, {key: 'loadingScene'});
    },

    preload: function() {
        this.load.setCORS('anonymous');

        this.load.atlasXML(
            'blueSheet', 
            'assets/UIpack/Spritesheet/blueSheet.png',
            'assets/UIpack/Spritesheet/blueSheet.xml'
        );

        this.load.atlasXML(
            'greenSheet', 
            'assets/UIpack/Spritesheet/greenSheet.png',
            'assets/UIpack/Spritesheet/greenSheet.xml'
        );

        this.load.atlasXML(
            'redSheet', 
            'assets/UIpack/Spritesheet/redSheet.png',
            'assets/UIpack/Spritesheet/redSheet.xml'
        );

        this.load.atlasXML(
            'greySheet',
            'assets/UIpack/Spritesheet/greySheet.png',
            'assets/UIpack/Spritesheet/greySheet.xml'
        );

        this.load.image('white_square', 'assets/images/white.png');
        this.load.image('bg', 'assets/images/bgtears.jpg');
        this.load.image('win1', 'assets/images/gameover/win/1.png');
        this.load.image('lose1', 'assets/images/gameover/lose/1.png');
        this.load.image('lose2', 'assets/images/gameover/lose/2.png');
        this.load.image('lose3', 'assets/images/gameover/lose/3.png');
        this.load.image('lose4', 'assets/images/gameover/lose/4.png');
        this.load.image('lose5', 'assets/images/gameover/lose/5.png');
        this.load.image('lose6', 'assets/images/gameover/lose/6.png');

        this.load.audio('correctAudio', 'assets/audio/positive.mp3');
        this.load.audio('wrongAudio', 'assets/audio/negative.mp3');
        this.load.json('questions', 'https://db.nov.blue/data/trivia');

        /*
        this.load.image('sky', 'src/games/firstgame/assets/sky.png');
        this.load.image('ground', 'src/games/firstgame/assets/platform.png');
        this.load.image('star', 'src/games/firstgame/assets/star.png');
        this.load.image('bomb', 'src/games/firstgame/assets/bomb.png');
        this.load.spritesheet('dude', 'src/games/firstgame/assets/dude.png', { frameWidth: 32, frameHeight: 48 });
        */
    },

    create: function() {
        this.scene.start('homeScene');
    }
});

