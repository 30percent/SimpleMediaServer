/*    4/01/2009
		PikaChoose
	Jquery plugin for photo galleries
	Copyright (C) 2009 Jeremy Fry

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/* thanks to Antonio Terceiro for suggestion and implementation of the multi lang support*/
jQuery.iPikaChoose = {
	build : function(user_options)
	{
		var user_options;
		var defaults = {
			show_captions: true,
			slide_enabled: true,
			auto_play: true,
			show_prev_next: true,
			slide_speed: 5000,
			thumb_width: 50,
			thumb_height: 40,
			buttons_text: { play: "Play", stop: "Stop", previous: "", next: "" },
			delay_caption: false,
			user_thumbs: true,
			transition: [5]
		};

		return jQuery(this).each(
			function() {
				//bring in options
				var options = jQuery.extend(defaults, user_options);
				// grab our images
				var images = jQuery(this).children('li').children('img');
				//hide the images so the user doesn't see crap
				images.fadeOut(1);

				//save our list for future ref
				var ulist = jQuery(this);
				images.each(LoadImages);
				//start building structure
				jQuery(this).before("<div class='pika_main'></div>");
				// houses eveything about the UL
				var main_div = jQuery(this).prev(".pika_main");

				//add in slideshow elements when appropriate
				if(options.slide_enabled){
					main_div.append("<div class='pika_play'></div>");
					var play_div = jQuery(this).prev(".pika_main").children(".pika_play");
					play_div.html("<a class='pika_play_button'>" + options.buttons_text.play + "</a><a class='pika_stop_button'>" + options.buttons_text.stop + "</a>");
					play_div.fadeOut(1);
					var play_anchor = play_div.children('a:first');
					var stop_anchor = play_div.children('a:last');
				}
				//this div is used to make image and caption fade together
				main_div.append("<div class='pika_subdiv'></div>");
				var sub_div = main_div.children(".pika_subdiv");

				//the main image we'll be using to load
				sub_div.append("<img />");
				var main_img = sub_div.children("img");

				//create the caption div when appropriate
				if(options.show_captions){
					sub_div.append("<div class='pika_caption'></div>");
					var caption_div = sub_div.children(".pika_caption");
				}

				//navigation div ALWAYS gets created, its refrenced a lot				
				jQuery(this).after("<div class='pika_navigation'></div>");
				var navigation_div = jQuery(this).next(".pika_navigation");
				//fill in sub elements
				navigation_div.prepend("<a class='pika_play_previous'>" + options.buttons_text.previous + "</a><a class='pika_play_next'>" + options.buttons_text.next + "</a>");
				var previous_image_anchor = navigation_div.children('a:first');
				var next_image_anchor = navigation_div.children('a:last');

				//hide the navigation if the user doesn't want it
				if(!options.show_prev_next){
					navigation_div.css("display","none");
				}

				//playing triggers the loop for the slideshow
				var playing = options.auto_play;

				main_img.wrap("<a></a>");
				var main_link = main_img.parent("a");

				function LoadImages()
				{
					jQuery(this).bind("load", function()
					{
						//had to make a seperate function so that the thumbnails wouldn't have problems
						//from beings resized before loaded, thus not h/w

						var w = jQuery(this).width();
						var h = jQuery(this).height();
						if(w===0){w = jQuery(this).attr("width");}
						if(h===0){h = jQuery(this).attr("height");}
						//grab a ratio for image to user defined settings
						var rw = options.thumb_width/w;
						var rh = options.thumb_height/h;

						//determine which has the smallest ratio (thus needing
						//to be the side we use to scale so our whole thumb is filled)
						if(rw<rh){
							//we'll use ratio later to scale and not distort
							var ratio = rh;
							var left = ((w*ratio-options.thumb_width)/2)*-1;
							left = Math.round(left);
							//set images left offset to match
							jQuery(this).css({left:left});
						}else{
							var ratio = rw;
							//you can uncoment this lines to have the vertical picture centered
							//but usually tall photos have the focal point at the top...
							//var top = ((h*ratio-options.thumb_height)/2)*-1;
							//var top = Math.round(top);
							var top = 0;
							jQuery(this).css({top:top});
						}
						//use those ratios to calculate scale
						var width = Math.round(w*ratio);
						var height = Math.round(h*ratio);
						jQuery(this).css("position","relative");
						jQuery(this).width(width).height(height);
						var imgcss={
							width: width,
							height: height
						};
						jQuery(this).css(imgcss);					
						jQuery(this).hover(
							function(){jQuery(this).fadeTo(250,1);},
							function(){if(!jQuery(this).hasClass("pika_selected")){jQuery(this).fadeTo(250,0.6);}}
						);
						jQuery(this).fadeTo(250,0.6);	

						if(jQuery(this).hasClass('pika_first')){
							jQuery(this).trigger("click",["auto"]);
						}

					});

					//clone so the on loads will fire correctly
					var newImage = jQuery(this).clone(true).insertAfter(this);

					jQuery(this).remove();

					//reset images to the clones
					images = ulist.children('li').children('img');
				}
			function activate()
			{
				//sets the intial phase for everything

				//image_click is controls the fading
				images.bind("click",image_click);
				//hiding refrence to slide elements if slide is disabled
				if(options.slide_enabled){
					if(options.auto_play){
						playing = true;
						play_anchor.hide();
						stop_anchor.show();
					}else{
						play_anchor.show();
						stop_anchor.hide();
					}
				}

				images.filter(":last").addClass("pika_last");
				images.filter(":first").addClass("pika_first");
				//css for the list
				var licss = {
					width: options.thumb_width+"px",
					height: options.thumb_height+"px",
					"list-style": "none",
					overflow: "hidden"
				};
				images.each(function(){
					jQuery(this).parent('li').css(licss);
					//fixes a bug where images don't get the correct display after loading
					if(jQuery(this).attr('complete')==true && jQuery(this).css('display')=="none")
					{
						jQuery(this).css({display:'inline'});
					}
				});
				//previous link to go back an image
				previous_image_anchor.bind("click",previous_image);
				//ditto for forward, also the item that gets auto clicked for slideshow
				next_image_anchor.bind("click",next_image);	
			}//end activate function

			function image_click(event, how){
					//catch when user clicks on an image Then cancel current slideshow
					if(how!="auto"){
						if(options.slide_enabled){
							stop_anchor.hide();
							play_anchor.show();
							playing=false;
						}
						main_img.stop();
						main_img.dequeue();
						if(options.show_captions)
						{
							caption_div.stop();
							caption_div.dequeue();
						}
					}
					//all our image variables
					if(options.user_thumbs)
					{		
						var image_source = jQuery(this).attr("ref");
					}else
					{
						var image_source = jQuery(this).attr("src");
					}
					var image_link = jQuery(this).attr("ref");
					var image_caption = jQuery(this).next("span").html();

					//fade out the old thumb
					images.filter(".pika_selected").fadeTo(250,.6); 
					images.filter(".pika_selected").removeClass("pika_selected"); 
					//fade in the new thumb
					jQuery(this).fadeTo(250,1);
					jQuery(this).addClass("pika_selected");
					//fade the old image out and the new one in
					if(options.show_captions)
					{
						if(options.delay_caption)
						{
							caption_div.fadeTo(800,0);
						}
						caption_div.fadeTo(500,0,function(){
							caption_div.html(image_caption);
							caption_div.fadeTo(800,1);
						});
					}

					main_img.fadeTo(500,0.07,function(){
						main_img.attr("src",image_source);
						main_link.attr("href", image_link);

						main_img.fadeTo(800,1,function(){
							if(playing){
								jQuery(this).animate({top:0},options.slide_speed, function(){
									//redudency needed here to catch the user clicking on an image during a change.
									if(playing){next_image_anchor.trigger("click",["auto"]);}
								});
							}
						});
					});
			}//end image_click function

			function next_image(event, how){
				if(images.filter(".pika_selected").hasClass("pika_last")){
					images.filter(":first").trigger("click",how);
				}else{
					images.filter(".pika_selected").parent('li').next('li').children('img').trigger("click",how);
				}
			}//end next image function

			function previous_image(event, how){
				if(images.filter(".pika_selected").hasClass("pika_first")){
					images.filter(":last").trigger("click",how);
				}else{
					images.filter(".pika_selected").parent('li').prev('li').children('img').trigger("click",how);
				}
			}//end previous image function

			function play_button(){
				main_div.hover(
					function(){play_div.fadeIn(400);},
					function(){play_div.fadeOut(400);}
				);
				play_anchor.bind("click", function(){
					main_img.stop();
					main_img.dequeue();
					if(options.show_captions)
					{
						caption_div.stop();
						caption_div.dequeue();
					}
					playing = true;
					next_image_anchor.trigger("click",["auto"]);
					jQuery(this).hide();
					stop_anchor.show();
				});
				stop_anchor.bind("click", function(){
					playing = false;
					jQuery(this).hide();
					play_anchor.show();
				});
			}
			if(options.slide_enabled){play_button();}
			activate();

		});//end return this.each
	}//end build function

	//activate applies the appropriate actions to all the different parts of the structure.
	//and loads the sets the first image
};//end jquery.ipikachoose		
jQuery.fn.PikaChoose = jQuery.iPikaChoose.build;