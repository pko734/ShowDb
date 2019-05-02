var GameScene = new Phaser.Class({

    Extends: Phaser.Scene,

    initialize:

    function GameScene ()
    {
        Phaser.Scene.call(this, { key: 'gameScene'});
    },
    
    init: function(data) {
        let key = 'blueSheet';
        let btn = 'blue_button00.png';
        this.score = data.score || 0;
        this.numCorrect = data.numCorrect || 0;
        this.timeBonus = data.timeBonus || 0;
        this.numWrong = data.numWrong || 0;
        this.questions = this.cache.json.get('questions');
        this.timeLimit = 10;
        this.uiBlocked = true;
        this.activeQ = ((data.round - 1) * data.roundLength) - 1;
        this.choiceContainers = [];
        this.round = data.round;
        this.roundLength = data.roundLength;
        this.flyAwayDelay = 1800;
    },

    create: function ()
    {
        this.scale.on('leavefullscreen', function() { 
            this.scale.refresh();
        }, this);

        this.input.keyboard.on('keycombomatch', function (event) {
            this.showCredits();
        }, this);

        this.createBackground();
        this.createRoundDisplay();
        this.createQuestionDisplay();
        this.nextQuestion();
    },

    showCredits: function() {
        this.uiBlocked = true;
        this.creditbg = this.add.graphics();
        this.creditbg.fillStyle(0x000000, 0.8);
        this.creditbg.fillRect(0, 0, this.sys.game.config.width, this.sys.game.config.height);
        let b = "Thank you for playing\n\n\n\n\n";
        let c = "Developer                      Paul Oehler\n\n" + 
                "Question Writers               Tim Mossberger\n" + 
                "                               Paul Oehler\n\n" +
                "Testers                        Hazy Mossberger\n" +
                "                               Tim Mossberger\n" +
                "                               Alison Oehler\n" +
                "                               Paul Oehler\n\n\n";
        let d = "Special Thanks To Our Patrons (April 2019)\n\n" +
                "Jay Akers\n" + 
                "Juli Anderson\n" +
                "Leslie Baney\n" +
                "Shaunda Belanger\n" +
                "Carly Billings\n" +
                "Yvonne Bland\n" +
                "Sharyn K. Boyle\n" +
                "Kelly Bradford\n" +
                "Nedra Bray\n" +
                "Tara Brown\n" +
                "Theresa Burke\n" +
                "David Butler\n" +
                "Mark Camper\n" +
                "Nikki Clements\n" +
                "Kaylyn Cole\n" +
                "Stephanie Coleman\n" +
                "Josh Comes\n" +
                "Lynn Cooper\n" +
                "Sue Corbett\n" +
                "Jen Cox\n" +
                "Katie Danielson\n" +
                "Wendy Stone Dabbous\n" +
                "Rose Davidson\n" +
                "Ann Derryberry\n" +
                "Jeremy Derryberry\n" +
                "Chris Dethloff\n" +
                "Leah Dickinson\n" +
                "Sarah Elder\n" +
                "Amy Erickson\n" +
                "Wade Fielding\n" +
                "Debbie Fields\n" +
                "Jillian Fitch\n" +
                "Michael Ganz\n" +
                "Tracy Gardner \n" +
                "Gayle Gebhard\n" +
                "Amanda George\n" +
                "Teresa Giacomini\n" +
                "Bridget Grimm \n" +
                "Cori Haggard\n" +
                "Heather Henderson\n" +
                "Katherine Henrici\n" +
                "Darryl Henson\n" +
                "Glen Heppard \n" +
                "Carol Hines\n" +
                "Mary Hocking\n" +
                "Marja Huhta\n" +
                "Bethany Jensen\n" +
                "Jenni Jostad\n";
        let e = "Bridget Kennedy\n" +
                "Chris Kite Kelly\n" +
                "Laura Kitts\n" +
                "Gary Knowles\n" +
                "Michelle Castañeda Little\n" +
                "Tanya Marsh\n" +
                "Karmel Marshall\n" +
                "Dale Martin\n" +
                "Shoney McNabb\n" +
                "Heather McVoy\n" +
                "Justin Menezes\n" +
                "Holly Meyer\n" +
                "Penny Miller\n" +
                "Matt Morrison\n" +
                "Tina Morrison\n" +
                "Kimberly Neal\n" +
                "Michelle Pariseleti\n" +
                "Jani Parker\n" +
                "Sue Parker\n" +
                "Tara Parsons\n" +
                "Melissa and Craig Pawlyk\n" +
                "Micheal Rapsawich\n" +
                "James Regan\n" +
                "Ashley Rockwell\n" +
                "Jamey Rodgers\n" +
                "Carey Rongitsch \n" +
                "Joseph Rose\n" +
                "Karen D Rue\n" +
                "Kristin Russell\n" +
                "Henry Sackett\n" +
                "Ang Schyvinck\n" +
                "Aimee Seningen\n" +
                "Ryan Shaw\n" +
                "Sarah Shute\n" +
                "David Skonezny\n" +
                "Chris Slaughter\n" +
                "Rob Smith\n" +
                "Sheala Smith\n" +
                "Megan Smith \n" +
                "Stephanie Sobka\n" +
                "Shannon Spencer\n" +
                "Jennifer Spiegel\n" +
                "Bob & Julie Skinner\n" +
                "Caryn St John\n" +
                "Leslie Steele \n" +
                "Sharon Steinbock\n" +
                "Ryan Steinbock\n" +
                "Sarah Angst Stewart\n" +
                "Sarah Szumnarski\n" +
                "Sharon Tannich Murray\n" +
                "Landon Taylor\n" +
                "Jill Tuinier\n" +
                "Lauren Wagner\n" +
                "Beverly Waite \n" +
                "Carey Warburton\n" +
                "Ashley Washam\n" +
                "Nancy Wham\n" +
                "Fig White\n" +
                "Raleigh White\n" +
                "Ed White\n" +
                "Jo Williams\n" +
                "Courtney Wilson\n" +
                "Shea Wilson\n" +
                "Heather Wood\n" +
                "";
        let thx = this.add.text(0, 0, b, {
            font: '25px monospace',
            align: 'center'
        });
        thx.setOrigin(0.5, 0);
        thx.setLineSpacing(20);

        let credits = this.add.text(0, thx.height, c, {
            font: '25px monospace'
        });        
        credits.setOrigin(0.5, 0);
        credits.setLineSpacing(20);

        let credits2 = this.add.text(0, credits.height + thx.height, d, {
            font: '25px monospace',
            align: 'center'
        });
        credits2.setOrigin(0.5, 0);
        credits2.setLineSpacing(20);

        let credits3 = this.add.text(0, credits.height + credits2.height + thx.height - 25, e, {
            font: '25px monospace',
            align: 'center'
        });
        credits3.setOrigin(0.5, 0);
        credits3.setLineSpacing(20);

        this.creditCon = this.add.container(
            375, 
            this.sys.game.config.height,
            [thx, credits, credits2, credits3]
        );

        let crTween = this.tweens.add({
            targets: this.creditCon,
            duration: 60000,
            y: 0 - thx.height - credits.height - credits2.height - credits3.height,
            paused: false,
            onStart: function() {
                this.playingAudio = this.sound.add(
                    'creditsAudio',
                    {volume: 0.90}
                );
                this.playingAudio.play();
            },
            onComplete: function() {
                this.creditCon.destroy();
                this.creditbg.destroy();
                this.uiBlocked = false;
            },
            callbackScope: this,
        }, this);
    },

    createBackground: function() {
        let bg = this.add.sprite(0, 0, 'bg' + (((this.round - 1) % 20) + 1)).setOrigin(0, 0);
        bg.displayWidth = this.sys.game.config.width;
        bg.displayHeight = this.sys.game.config.height;
    },

    nextQuestion: function() {
        this.activeQ = (this.activeQ + 1);
        if(this.activeQ >= this.round * this.roundLength || this.numWrong > 0 || this.activeQ == this.questions.length) {
            if(this.numCorrect == this.roundLength * this.round && this.activeQ != this.questions.length) {
                this.nextRound();
                return;
            } else {
                this.gameOver();
                return;
            }
        }
        this.questionDisplay.setText('Questions: ' + (this.activeQ + 1));
        this.createQuestion();
        this.createChoices();
        this.bringInQuestion();
        this.bringInChoices();
        this.clock = this.timeLimit;
    },

    createRoundDisplay: function() {
        this.roundDisplay = this.add.text(0, 0, 'Round: ' + this.round, {
            fill: '#000',
            align: 'center',
            font: '25px Open Sans',
            backgroundColor: '#FFF'
        });
    },

    createQuestionDisplay: function() {
        this.questionDisplay = this.add.text(0, 0, 'Questions: ' + (this.activeQ + 2), {
            fill: '#000',
            align: 'center',
            font: '25px Open Sans',
            backgroundColor: '#FFF'
        });
        this.questionDisplay.setX(this.sys.game.config.width - this.questionDisplay.displayWidth);
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
        let logo = this.createLogo();
        let score = this.createScore();
        let easer = 'Quint.easeOut';
        let easeSpeed = 1000;
        
        let yayTween = this.tweens.add({
            targets: [img, btn, score, logo],
            duration: easeSpeed,
            x: this.sys.game.config.width / 2,
            paused: false,
            ease: easer,
            onComplete: function() {
                this.uiBlocked = false;
                if(this.score == this.questions.length * 100) {
                    let that = this;
                    that.uiBlocked = true;
                    setTimeout(function() {               
                        that.showCredits();
                    },
                    2000);
                }
            },
            callbackScope: this
        });
    },

    createLogo: function() {
        let gameWidth = this.sys.game.config.width;
        let logo = this.add.sprite(375 + gameWidth, 1150, 'dblogo-large');
        logo.setScale(0.8);
        logo.setInteractive();
        logo.on('pointerup', function() {
            window.location = 'https://db.nov.blue/';
            exit;
        });
        this.input.keyboard.createCombo([ 38, 38, 40, 40, 37, 39, 37, 39, 66, 65, 13 ], { resetOnMatch: true });
        return logo;
    },

    nextRound: function() {
        this.scene.start('homeScene', {
            round: this.round + 1, 
            roundLength: this.roundLength,
            numCorrect: this.numCorrect,
            score: this.score,
            timeBonus: this.timeBonus
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
        pic.setInteractive();
        this.creditForce = 0;
        pic.on('pointerup', function() {
            if(this.uiBlocked) return;
            this.creditForce++;
            if(this.creditForce == 20) {
                this.uiBlocked = true;
                this.showCredits();
                this.creditForce = 0;
            }
        }, this);

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
            if(this.uiBlocked) return;
            this.cache.json.remove('questions');
            for(let i = this.activeQ; i < this.roundLength * this.round; i++) {
                if(this.cache.audio.exists('question' + i + '_audio')) {
                    this.cache.audio.remove('question' + i + '_audio');                
                }
                if(this.game.textures.exists('question' + this.activeQ + '_image')) {
                    this.game.textures.remove('question' + i + '_image');
                }
            }
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
            'Score: ' + parseInt(this.score + this.timeBonus),
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
        let questionRect = this.add.sprite(0, 0, 'white_square');
        questionRect.setScale(4.5, 3.2);
        questionRect.setAlpha(0.8);
        let question = this.add.text(0, 0, this.questions[this.activeQ].question, {
            fill: '#000',
            align: 'center',
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
            question.setBackgroundColor('rgba(255,255,255,0.5)');
        } else {
            parts = [questionRect, question];
        }
        this.rectContainer = this.add.container(
            375, 
            400, 
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
                800 + (i * 120), 
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
            100, 
            this.timeLimit + '.00', 
            {
                font: '50px Open Sans',
                color: '#8B0000'
            }
        ).setOrigin(0.5, 0.5);
        this.clockText.depth = 1;

        this.clockBg = this.add.graphics();
        this.clockBg.fillStyle(0xFFFFFF, 1.0);
        this.clockBg.fillCircle(this.clockText.x, this.clockText.y, 45);

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
        this.showCorrectAnswer();
        this.numWrong++;
        this.time.addEvent({
            delay: this.flyAwayDelay,
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
            this.timeBonus += parseFloat(this.clockText.text) / 2;
        } else {
            item.setTexture('redSheet', 'red_button11.png');
            this.sound.play('wrongAudio');
            this.showCorrectAnswer();
            this.numWrong++;
        }
        this.time.addEvent({
            delay: this.flyAwayDelay,
            callbackScope: this,
            callback: function() {
                this.flyAway();
            },
            repeat: 0
        });
    },

    showCorrectAnswer: function() {
        let items = this.items.getChildren();
        for(let i=0; i < items.length; i++) {
            if(this.questions[this.activeQ].choices[i].correct) {
                items[i].setTexture('greenSheet', 'green_button00.png');
                break;
            }
        }
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
                                        this.deleteQuestion();
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

    deleteQuestion: function() {
        if(this.rectContainer) {
            this.rectContainer.destroy();
            if(this.game.textures.exists('question' + this.activeQ + '_image')) {
                this.game.textures.remove('question' + this.activeQ + '_image');
            }
        }
    },

    update: function ()
    {
        if(!this.timer) return;
        if(this.clock > 0) {
            if(this.timer.paused) return;
            this.clockText.setText((this.clock - this.timer.getProgress()).toFixed(1));
        } else {
            if(this.clockText.text == '0.0') return;
            this.clockText.setText('0.0');
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

