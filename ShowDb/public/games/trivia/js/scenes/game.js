var GameScene = new Phaser.Class({

    Extends: Phaser.Scene,

    initialize:

    function GameScene ()
    {
        Phaser.Scene.call(this, { key: 'gameScene'});
    },
    
    init: function () {
        let key = 'blueSheet';
        let btn = 'blue_button00.png';
        this.score = 0;
        this.numCorrect = 0;
        this.timeBonus = 0;
        this.questions = this.cache.json.get('questions');
        this.timeLimit = 10;
        this.uiBlocked = true;
        this.activeQ = -1;
        this.choiceContainers = [];
    },

    create: function ()
    {
        this.createBackground();
        this.nextQuestion();
    },

    createBackground: function() {
        let bg = this.add.sprite(0, 0, 'bg').setOrigin(0, 0);
        bg.displayWidth = this.sys.game.config.width;
        bg.displayHeight = this.sys.game.config.height;
    },

    nextQuestion: function() {
        if(this.rectContainer) {
            this.rectContainer.destroy();
            if(this.game.textures.exists('question' + this.activeQ + '_image')) {
                this.game.textures.remove('question' + this.activeQ + '_image');
            }
        }
        this.activeQ = (this.activeQ + 1);        
        if(this.activeQ > this.questions.length - 1) {
            this.gameOver();
            return;
        }
        this.createQuestion();
        this.createChoices();
        this.bringInQuestion();
        this.bringInChoices();
        this.clock = this.timeLimit;
    },

    bringInQuestion: function() {
        return;
    },

    bringInChoices: function() {
        let easer = 'Bounce.easeOut';
        let easeSpeed = 800;
        let tween1 = this.tweens.add({
            targets: this.choiceContainers[0],
            duration: easeSpeed,
            scaleX: 1,
            scaleY: 1,
            paused: false,
            ease: easer,
            callbackScope: this,
            onStart: function(tween, sprites) {
                let tween2 = this.tweens.add({
                    targets: this.choiceContainers[1],
                    duration: easeSpeed,
                    scaleX: 1,
                    scaleY: 1,
                    paused: false,
                    ease: easer,
                    delay: 100,
                    callbackScope: this,
                    onStart: function(tween, sprites) {                    
                        let tween3 = this.tweens.add({
                            targets: this.choiceContainers[2],
                            duration: easeSpeed,
                            scaleX: 1,
                            scaleY: 1,
                            paused: false,
                            ease: easer,
                            callbackScope: this,
                            delay: 200,
                            onStart: function(tween, sprites) {                    
                                let tween4 = this.tweens.add({
                                    targets: this.choiceContainers[3],
                                    duration: easeSpeed,
                                    scaleX: 1,
                                    scaleY: 1,
                                    paused: false,
                                    ease: easer,
                                    delay: 300,
                                    callbackScope: this,
                                    onComplete: function(tween, sprites) {                    
                                        this.createCountdown();
                                        if(this.cache.audio.get('question' + this.activeQ + '_audio')) {
                                            this.playingAudio = this.sound.add(
                                                'question' + this.activeQ + '_audio',
                                            );
                                            this.playingAudio.play();
                                        }
                                        this.uiBlocked = false;
                                        this.timer.paused = false;                                        
                                    }
                                });
                            }
                        });

                    }
                });
            }
        });

    },

    gameOver: function() {
        this.clockText.destroy();
        this.clockBg.destroy();
        let img = this.createGameOverImage();
        let btn = this.createPlayAgain();
        let score = this.createScore();
        let easer = 'Quint.easeOut';
        let easeSpeed = 1000;
        
        let yayTween = this.tweens.add({
            targets: [img, btn, score],
            duration: easeSpeed,
            x: this.sys.game.config.width / 2,
            paused: false,
            ease: easer
        });
    },

    createGameOverImage: function() {
        let gameWidth = this.sys.game.config.width;
        let img = '';
        if(this.score == this.questions.length * 100) {
            img = 'win1';
        } else {
            img = 'lose' + ((Math.floor(Math.random() * 6 + 1)));
        }
        let pic = this.add.sprite(375 + gameWidth, 500, img);
        pic.displayWidth = 600;
        pic.displayHeight = 600;
        return pic;        
    },

    createPlayAgain: function() {
        let gameWidth = this.sys.game.config.width;
        let startBtn = this.add.sprite(
            0, 
            0, 
            'greySheet',
            'grey_button00.png'
        );
        startBtn.setInteractive();
        startBtn.setScale(3);
        startBtn.on('pointerdown', function(pointer) {
            this.cache.json.remove('questions');
            this.scene.start('loadingScene');
        }, this);
        let startTxt = this.add.text(0, 0, 'Play Again', {
            fill: '#000',
            align: 'center',
            font: '64px Open Sans'
        });
        startTxt.setOrigin(0.5);
        let startCon = this.add.container(
            375 + gameWidth, 
            900, 
            [startBtn, startTxt]
        );
        return startCon;
    },

    createScore: function() {
        let gameWidth = this.sys.game.config.width;
        let scoreTxt = this.add.text(
            0,
            0,
            this.numCorrect + ' / ' + this.questions.length + ' Score: ' + parseInt((this.score + this.timeBonus)),
            {
                fill: '#000',
                align: 'center',
                font: '64px Open Sans'
            }
        );
        scoreTxt.setOrigin(0.5, 0.5);
        scoreTxt.depth = 1;

        let scoreBg = this.add.sprite(0, 0, 'white_square');
        scoreBg.displayHeight = scoreTxt.displayHeight + 20;
        scoreBg.displayWidth = scoreTxt.displayWidth + 20;

        let scoreCon = this.add.container(
            375 + gameWidth, 
            100, 
            [scoreBg, scoreTxt]
        );
        return scoreCon;
    },

    createQuestion: function() {
        questionRect = this.add.sprite(0, 0, 'white_square');
        questionRect.setScale(4.5, 3.2);
        let question = this.add.text(0, 0, this.questions[this.activeQ].question, {
            fill: '#000',
            align: 'center',
            backgroundColor: 'rgba(255,255,255,0.5)',
            font: '64px Open Sans',
            wordWrap: { width: questionRect.displayWidth, useAdvancedWrap: true}            
        });
        let parts = [];
        let yOffset = 0;
        if(this.questions[this.activeQ].image) {
            let img = this.add.image(0, 0, 'question' + this.activeQ + '_image');
            img.displayHeight = questionRect.displayHeight;
            img.displayWidth = questionRect.displayHeight;
            yOffset = questionRect.displayHeight - question.displayHeight;
            parts = [questionRect, img, question];
            question.setScale(0.7);
        } else {
            parts = [questionRect, question];
        }
        this.rectContainer = this.add.container(
            375, 
            500, 
            parts
        );
        question.setOrigin(0.5)
            .setX(this.rectContainer.width / 2)
            .setY(this.rectContainer.height + yOffset / 2);
    },

    createChoices: function() {
        this.choiceContainers = [];
        this.items = this.add.group(this.questions[this.activeQ].choices);
        let items = this.items.getChildren();
        // add buttons
        for(let i=0; i < items.length; i++) {
            let item = items[i];
            item.setInteractive();
            let x = 0;
            let y = 0;
            let text = this.add.text(0, 0, this.questions[this.activeQ].choices[i].text, {
                font: '52px Open Sans',
                fill: '#fff'
            });
            item.on('pointerdown', function(pointer) {
                if(this.uiBlocked) return;
                this.questions[this.activeQ].choices[i].pressed = true;
                item.setFrame('blue_button01.png');
                text.setY(container.height / 2);
            }, this);
            item.on('pointerup', function(pointer) {
                if(this.uiBlocked) return;
                if(this.questions[this.activeQ].choices[i].pressed) {
                    this.questions[this.activeQ].choices[i].pressed = false;
                    item.setFrame('blue_button00.png');
                    text.setY(container.height / 2 - 5);
                    this.processAnswer(this.questions[this.activeQ].choices[i], item);
                }
            }, this);
            item.on('pointerout', function(pointer) {
                if(this.uiBlocked) return;
                item.setFrame('blue_button00.png');
                text.setY(container.height / 2 - 5);
                this.questions[this.activeQ].choices[i].pressed = false;
            }, this);
            let container = this.add.container(
                375, //+ this.sys.game.config.width, 
                900 + (i * 110), 
                [item, text]
            );

            text.setOrigin(0.5)
                .setY(-5);

            while(text.displayWidth > item.displayWidth - 30) {
                text.setScale(text.scaleX - 0.01);
            }
            this.choiceContainers.push(container.setScale(0.001));
        }

    },

    createCountdown: function() {
        if(this.clockText) {
            this.clockText.destroy();
            this.clockBg.destroy();
        }

        let gameWidth = this.sys.game.config.width;
        this.clockText = this.add.text(
            gameWidth / 2, 
            150, 
            this.timeLimit + '.00', 
            {
                font: '60px Open Sans'            
            }
        ).setOrigin(0.5, 0.5);
        this.clockText.depth = 1;

        this.clockBg = this.add.graphics();
        this.clockBg.fillStyle(0x00000, 0.5);
        this.clockBg.fillRect(gameWidth/2 - this.clockText.displayWidth/2 - 10, 
                        150 - this.clockText.displayHeight/2 - 10,
                        this.clockText.displayWidth + 20,
                        this.clockText.displayHeight + 20);

        this.timer = this.time.addEvent({
            delay: 1000,
            callback: this.countDown,
            callbackScope: this, 
            repeat: this.timeLimit - 1,
            paused: true
        });
    },

    countDown: function () {
        if(!this.timer) return;
        this.clock -= 1;
        if(this.clock == 0) {
            this.timeout();
        }
    },

    timeout: function() {
        this.uiBlocked = true;
        this.timer.paused = true;
        this.stopPlayingAudio();
        this.sound.play('wrongAudio');
        this.time.addEvent({
            delay: 1000,
            callbackScope: this,
            callback: function() {
                this.flyAway();
            },
            repeat: 0
        });
    },

    stopPlayingAudio: function() {
        if(this.playingAudio) {
            this.playingAudio.stop();
            this.playingAudio.destroy();
            this.playingAudio = null;
            this.cache.audio.remove('question' + this.activeQ + '_audio');
        }
    },

    processAnswer: function(choice, item) {
        this.uiBlocked = true;
        this.timer.paused = true;
        this.stopPlayingAudio();
        if(choice.correct) {
            item.setTexture('greenSheet', 'green_button00.png');
            this.sound.play('correctAudio');
            this.numCorrect++;
            this.score += 100;
            this.timeBonus += parseFloat(this.clockText.text);
        } else {
            item.setTexture('redSheet', 'red_button11.png');
            this.sound.play('wrongAudio');
        }
        this.time.addEvent({
            delay: 1000,
            callbackScope: this,
            callback: function() {
                this.flyAway();
            },
            repeat: 0
        });
    },

    flyAway: function() {
        let easer = 'Quint.easeOut';
        let easeSpeed = 1000;
        let tween1 = this.tweens.add({
            targets: this.choiceContainers[0],
            duration: easeSpeed,
            x: -this.sys.game.config.width,
            paused: false,
            ease: easer,
            callbackScope: this,
            onStart: function(tween, sprites) {
                let tween2 = this.tweens.add({
                    targets: this.choiceContainers[1],
                    duration: easeSpeed,
                    x: -this.sys.game.config.width,
                    paused: false,
                    ease: easer,
                    delay: 100,
                    callbackScope: this,
                    onStart: function(tween, sprites) {                    
                        let tween3 = this.tweens.add({
                            targets: this.choiceContainers[2],
                            duration: easeSpeed,
                            x: -this.sys.game.config.width,
                            paused: false,
                            ease: easer,
                            callbackScope: this,
                            delay: 200,
                            onStart: function(tween, sprites) {                    
                                let tween4 = this.tweens.add({
                                    targets: this.choiceContainers[3],
                                    duration: easeSpeed,
                                    x: -this.sys.game.config.width,
                                    paused: false,
                                    ease: easer,
                                    delay: 300,
                                    callbackScope: this,
                                    onComplete: function(tween, sprites) {                    
                                        this.nextQuestion();
                                    }
                                });
                            }
                        });

                    }
                });
            }
        });

    },

    update: function ()
    {
        if(!this.timer) return;
        if(this.clock > 0) {
            if(this.timer.paused) return;
            this.clockText.setText((this.clock - this.timer.getProgress()).toFixed(2));
        } else {
            if(this.clockText.text == '0.00') return;
            this.clockText.setText('0.00');
        }
        /*
        var cursors = this.cursors;
        var player = this.player;

        if (cursors.left.isDown)
        {
            player.setVelocityX(-160);

            player.anims.play('left', true);
        }
        else if (cursors.right.isDown)
        {
            player.setVelocityX(160);

            player.anims.play('right', true);
        }
        else
        {
            player.setVelocityX(0);

            player.anims.play('turn');
        }

        if (cursors.up.isDown && player.body.touching.down)
        {
            player.setVelocityY(-330);
        }
        */
    },

    /*
    collectStar: function (player, star)
    {
        star.disableBody(true, true);

        this.score += 10;
        this.scoreText.setText('Score: ' + this.score);
    }
    */
});

