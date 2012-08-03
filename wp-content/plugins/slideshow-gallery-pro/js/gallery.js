var TINY={};
function tid(i){return document.getElementById(i)}
function tag(e,p){p=p||document; return p.getElementsByTagName(e)}
TINY.sgpro_slideshow=function(n){
	this.infoSpeed=this.imgSpeed=this.speed=10;
	this.thumbOpacity=this.navHover=70;
	this.navOpacity=25;
	this.scrollSpeed=5;
	this.letterbox='#000';
	this.n=n;
	this.c=0;
	this.a=[]
};
TINY.sgpro_slideshow.prototype={
	init:function(s,z,b,f,q){
		s=tid(s);
		var m= tag('li',s), i=0, w=0;
		this.l=m.length;
		this.q=tid(q);
		this.f=tid(z);
		this.r=tid(this.info);
		this.oh=parseInt(TINY.style.val(z,'height'));
		this.o=parseInt(TINY.style.val(z,'width'));
		if(this.thumbs){
			var u=tid(this.left), r=tid(this.right);
			u.onmouseover=new Function('TINY.scroll.init("'+this.thumbs+'",-1,'+this.scrollSpeed+')');
			u.onmouseout=r.onmouseout=new Function('TINY.scroll.cl("'+this.thumbs+'")');
			r.onmouseover=new Function('TINY.scroll.init("'+this.thumbs+'",1,'+this.scrollSpeed+')');
			this.p=tid(this.thumbs)
		}
		
		for(i;i<this.l;i++){
			this.a[i]={};
			var h=m[i], a=this.a[i];
			a.t= tag('h5',h)[0].innerHTML;
			a.d= tag('p',h)[0].innerHTML;
			a.l= tag('a',h)[0]? tag('a',h)[0].href:'';
			a.p= tag('span',h)[0].innerHTML;
			a.u= tag('h4',h)[0].innerHTML;
			if(this.thumbs){
				var g = tag('img',h)[0];
				this.p.appendChild(g);
				var thw = g.offsetWidth;
				if (this.thumbHeight > thw) { thw = this.thumbHeight; }
				w+=parseInt(thw);
				if(i!=this.l-1){
					g.style.marginRight=this.spacing+'px'; 
					w+=this.spacing + 6;// 6 is for 2 border pixels and 4 padding pixels
				}
				this.p.style.width=w+this.spacing+6+'px';
				g.style.opacity=this.thumbOpacity/100;
				g.style.filter='alpha(opacity='+this.thumbOpacity+')';
				g.onmouseover=new Function('TINY.alpha.set(this,100,5)');
				g.onmouseout=new Function('TINY.alpha.set(this,'+this.thumbOpacity+',5)');
				g.onclick=new Function(this.n+'.pr('+i+',1)')
			}
		}
		if(b&&f){
			b=tid(b);
			f=tid(f);
			b.style.opacity=f.style.opacity=this.navOpacity/100;
			b.style.filter=f.style.filter='alpha(opacity='+this.navOpacity+')';
			b.onmouseover=f.onmouseover=new Function('TINY.alpha.set(this,'+this.navHover+',5)');
			b.onmouseout=f.onmouseout=new Function('TINY.alpha.set(this,'+this.navOpacity+',5)');
			b.onclick=new Function(this.n+'.mv(-1,1)');
			f.onclick=new Function(this.n+'.mv(1,1)')
		}
		if (this.info && this.infoShow == "H") {
		jQuery("#information").hide();
			jQuery('#'+this.wrap).hover(function(){
				jQuery("#information").fadeIn("slow");
			},
			function() {
				jQuery("#information").fadeOut();
			});
		}
		this.auto?this.is(0,0):this.is(0,1)
	},
	striptlt:function(x){
		x.value = x.value.replace(/['"]/g,'');
	},
	resize:function(i,w,h){ //image & size of width or height
		if (jQuery(this.i).is(":visible")) { 
			this.iwidth = this.i.width; // Read width differently depending on visibility
			this.iheight = this.i.height;
			if (this.iheight == 0) {this.iheight = jQuery(this.i).height();}
		} else { 
			this.iwidth = (this.oh*this.i.width)/this.i.height;
			this.iheight = (this.o*this.i.height)/this.i.width;
		}
		if (w != null) { // resize to width 
			return this.iheight;
		 } else if (h != null) {	//resize to height
			return this.iwidth;
		 }
		 else { return null; }
	},
	mv:function(d,c){
		var t=this.c+d;
		this.c=t=t<0?this.l-1:t>this.l-1?0:t;
		this.pr(t,c)
	},
	pr:function(t,c){
		clearTimeout(this.lt);
		if(c){
			clearTimeout(this.at)
		}
		this.c=t;
		this.is(t,c)
	},
	is:function(s,c){
		if(this.info){
			TINY.height.set(this.r,1,this.infoSpeed/2,-1,this.infoShow)
		}
		var i=new Image();
		i.style.opacity=0;
		i.style.filter='alpha(opacity=0)';
		this.i=i;
		i.onload=new Function(this.n+'.le('+s+','+c+')');
		i.src=this.a[s].p;
		i.id=this.a[s].u;
		//jQuery('#sgpro_image img').wrap('<div class="sgpro_holder" />');
		if(this.thumbs){
			var a= tag('img',this.p), l=a.length, x=0;
/*			var a= tag('rel','lightbox');*/
			for(x;x<l;x++){
				a[x].style.borderColor=x!=s?'':this.active
			}
		}
	},
	le:function(s,c){
		this.f.appendChild(this.i);
		//jQuery(this.i).css( 'display','block' });
		var iheight = this.resize(this.i,this.o,null);
		var ht = this.oh-parseInt(iheight);
		var iwidth = this.resize(this.i,null,this.oh);
		var w = this.o-parseInt(iwidth); //this.o is width box
		if (ht > 0 && this.widecenter) { // WIDE
			var l=Math.floor(ht/2);
			this.i.style.borderTop=(ht-l)+'px solid ' + this.letterbox;
			this.i.style.borderBottom=(ht-l)+'px solid ' + this.letterbox;
		}
		TINY.alpha.set(this.i,100,this.imgSpeed);
		var n=new Function(this.n+'.nf('+s+')');
		this.lt=setTimeout(n,this.imgSpeed*100);
		if(!c){
			this.at=setTimeout(new Function(this.n+'.mv(1,0)'),this.speed*1000)
		}
		if(this.a[s].l != ""){		
			var baseURL = this.a[s].l;
			var urlString = /\.jpg$|\.jpeg$|\.png$|\.gif$|\.swf$|\.bmp$/;
			var urlType = baseURL.toLowerCase().match(urlString);
			/***** NOLINK ****/
			//alert("file ending: "+baseURL);
			if (( this.nolink || this.imagesbox == "nolink" ) && ( urlType == '.jpg' || urlType == '.JPG' || urlType == '.jpeg' || urlType == '.png' || urlType == '.PNG' || urlType == '.gif' || urlType == '.bmp' || urlType == '.swf' )) {
				this.q.onclick=this.q.onmouseover=null;
				this.q.style.cursor='default';
				this.q.style.backgroundImage='none';
			/**** THICKBOX ***/
			} else if ( this.imagesbox == "thickbox" && ( urlType == '.jpg' || urlType == '.JPG' || urlType == '.jpeg' || urlType == '.png' || urlType == '.PNG' || urlType == '.gif' || urlType == '.bmp' || urlType == '.swf' )) {
				var thickpath = (( this.a[s].p ).replace(/\/wp-content.*/g,"/wp-includes/js/thickbox/" ));
				tb_pathToImage = thickpath + "loadingAnimation.gif";
				tb_closeImage = thickpath + "tb-close.png";
				this.q.onclick = new Function('tb_show("' + this.a[s].t.replace(/['"]/g,'') + '", "' + this.a[s].l + '", "sgpro_slideshow" )' );
			/**** SHADOWBOX ***/
			} else if ( this.imagesbox == "shadowbox" && (urlType == '.jpg' || urlType == '.JPG' || urlType == '.jpeg' || urlType == '.png' || urlType == '.PNG' || urlType == '.gif' || urlType == '.bmp' || urlType == '.swf' )) {
				this.q.onclick = new Function( 'Shadowbox.open({content: "' + this.a[s].l + '",player: "img",title: "' + this.a[s].t.replace(/['"]/g,'') + '",gallery:"'+this.gallery+'"})');
			/**** PRETTYPHOTO ***/
			} else if ( this.imagesbox == "prettyphoto" && (urlType == '.jpg' || urlType == '.JPG' || urlType == '.jpeg' || urlType == '.png' || urlType == '.PNG' || urlType == '.gif' || urlType == '.bmp' || urlType == '.swf' )) {
				this.q.onclick = new Function( 'jQuery.prettyPhoto.open("' + this.a[s].l + '","' + this.a[s].t.replace(/['"]/g,'') + '")');				
			/**** WINDOW & PAGE LINKING ***/
			} else {
				if (this.pagelink == "self") { this.q.onclick = new Function( 'window.location="' + this.a[s].l + '"' ); }
				else { this.q.onclick = new Function( 'window.open("' + this.a[s].l + '")' ); }
			}
			this.q.onmouseover = new Function('this.className="' + this.linkclass + '"');
			this.q.onmouseout = new Function('this.className=""');
			this.q.style.cursor = 'pointer';
			this.q.style.height='100%';
		}else{
			this.q.onclick=this.q.onmouseover=null;
			this.q.style.cursor='default';
			this.q.style.backgroundImage='none';
		}		
		var m= tag('img',this.f);
		if(m.length > 1){
			jQuery(m[0]).fadeOut('slow', function() {
				jQuery(m[0]).remove();
				if(m.length > 1)
					m[0].remove();
			 });
		}
	},
	nf:function(s){
		if(this.info){
			s=this.a[s];
			tag('h5',this.r)[0].innerHTML=s.t;
			tag('p',this.r)[0].innerHTML=s.d;
			this.r.style.height='auto';
			var h=parseInt(this.r.offsetHeight);
			// alert (h); // always 85
			this.r.style.height=0;
			TINY.height.set(this.r,h,this.infoSpeed,0,this.infoShow)
		}
	}
};
TINY.scroll=function(){
	return{
		init:function(e,d,s){
			e=typeof e=='object'?e: tid(e); var p=e.style.left||TINY.style.val(e,'left'); e.style.left=p;
			var l=d==1?parseInt(e.offsetWidth)-parseInt(e.parentNode.offsetWidth):0; e.si=setInterval(function(){TINY.scroll.mv(e,l,d,s)},20)
		},
		mv:function(e,l,d,s){
			var c=parseInt(e.style.left); if(c==l){TINY.scroll.cl(e)}else{var i=Math.abs(l+c); i=i<s?i:s; var n=c-i*d; e.style.left=n+'px'}
		},
		cl:function(e){e=typeof e=='object'?e: tid(e); clearInterval(e.si)}
	}
}();
TINY.height=function(){
	return{
		set:function(e,h,s,d,is){
			e=typeof e=='object'?e:tid(e); var oh=e.offsetHeight, ho=e.style.height||TINY.style.val(e,'height');
			ho=oh-parseInt(ho); var hd=oh-ho>h?-1:1; clearInterval(e.si); 
			if (is == "S") {
				e.si=setInterval(function(){TINY.height.tw(e,h,ho,hd,s)},20)
			} else {
				var oh=e.offsetHeight-ho-1;
				if (oh + h > 1) {e.style.height=oh+(Math.abs(h))+'px';}
			}
		},
		tw:function(e,h,ho,hd,s){
		var oh=e.offsetHeight-ho;
		if(oh == h){clearInterval(e.si)}else{if(oh!=h){
			e.style.height=oh+(Math.ceil(Math.abs(h-oh)/s)*hd)+'px'
			}}
		}
	}
}();
TINY.alpha=function(){
	return{
	set:function(e,a,s){
		e=typeof e=='object'?e:tid(e); var o=e.style.opacity||TINY.style.val(e,'opacity'),
		d=a>o*100?1:-1; e.style.opacity=o; clearInterval(e.ai); 
		e.ai=setInterval(function(){TINY.alpha.tw(e,a,d,s)},20)
	},
	tw:function(e,a,d,s){
		var y = e.style.opacity;
		if (typeof y == 'string') {
		y = e.style.opacity.replace(',', '.');
	}
	var o=Math.round(parseFloat(y)*100);
	if(o==a){clearInterval(e.ai)}
	else{var n=o+Math.ceil(Math.abs(a-o)/s)*d; e.style.opacity=n/100; e.style.filter='alpha(opacity='+n+')'}
	}
	}
}($);
TINY.style=function(){return{val:function(e,p){e=typeof e=='object'?e:tid(e); return e.currentStyle?e.currentStyle[p]:document.defaultView.getComputedStyle(e,null).getPropertyValue(p)}}}();