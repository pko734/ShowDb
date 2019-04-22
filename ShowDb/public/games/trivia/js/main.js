
var config = {
    type: Phaser.AUTO,
    scale: {
        mode: Phaser.Scale.FIT,
        parent: 'avett-quiz',
        autoCenter: Phaser.Scale.CENTER_BOTH,
        width: 750,
        height: 1334
    },
    /*
    physics: {
        default: 'arcade',
        arcade: {
            gravity: { y: 300 },
            debug: false
        }
    },
    */
    scene: [LoadingScene, HomeScene, GameScene],
    title: 'Avett'
};

var game = new Phaser.Game(config);