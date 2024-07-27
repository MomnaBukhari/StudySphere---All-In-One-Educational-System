// this is main scritp document of Home Page



document.addEventListener("DOMContentLoaded", function() {
    const questions = document.querySelectorAll(".faq .question");

    questions.forEach(function(question) {
        question.addEventListener("click", function() {
            this.classList.toggle("active");
        });
    });
});

//

document.addEventListener("DOMContentLoaded", function() {
    // GSAP card flip animation
    const boxes = document.querySelectorAll('.dynamic-stats-box');
    boxes.forEach(box => {
        gsap.set(box, { rotationY: 0 });
    });

    const flipCards = () => {
        boxes.forEach(box => {
            gsap.to(box, {
                duration: 1,
                rotationY: 180,
                ease: "power2.inOut",
                repeat: 1,
                yoyo: true
            });
        });
    };

    setInterval(flipCards, 5000);
});


//curson Animations

var section1=document.querySelector(".section1")
var section=document.querySelector(".section2")
// var section1_1=document.querySelector(".section1_1")
var sectionhelp = document.querySelector(".sectionhelp")
var elem=document.querySelector(".boxes")
var cursor=document.querySelector("#cursor")
// var rollbaseddasboardheading = document.querySelector(".rollbaseddasboardheading")
var roleintrocards=document.querySelector(".roleintrocards")
var introcardteacher=document.querySelector(".roleteacherdashboard")
var introcardstudent=document.querySelector(".rolestudentdashboard")
var introcardguardian=document.querySelector(".roleguardiandashboard")
var scrollcirlce = document.querySelector(".scrollcirlce")

scrollcirlce.addEventListener("mousemove", function (dets) {
    gsap.to(cursor, {
        x: dets.x,
        y: dets.y,
        duration: 1,
        ease: "back.out",
        opacity: 1
    })
})
scrollcirlce.addEventListener("mouseenter", function (dets) {
    gsap.to(cursor, {
        scale: 3,
        backgroundColor: "#CAF0F8",
        opacity: 1
    })
})
scrollcirlce.addEventListener("mouseleave", function (dets) {
    // cursor.innerHTML = "Scroll"
    gsap.to(cursor, {
        scale: 1,
        opacity: 0
    })
})


section1.addEventListener("mousemove",function(dets){
    cursor.innerHTML=""
    gsap.to(cursor,{
        opacity:0,
        delay:0
    })
})
section.addEventListener("mousemove",function(dets){
    gsap.to(cursor,{
        x:dets.x,
        y:dets.y,
        duration:1,
        ease:"back.out",
        opacity:1
    })
})
section.addEventListener("mouseenter",function(dets){
    // cursor.innerHTML="Want to know more? Join Today"
    gsap.to(cursor,{
        scale:2,
        backgroundColor:"#BEE3DB",
        opacity:1
    })
})
section.addEventListener("mouseleave",function(dets){
    cursor.innerHTML=""
    gsap.to(cursor,{
        scale:1,
        backgroundColor:"#ffff",
        opacity:0
    })
})


elem.addEventListener("mouseenter",function(dets){
    cursor.innerHTML = "<span style='color: white; font-size:5px ; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'>Isn't Great?</span>";
    gsap.to(cursor,{
        scale:9,
        backgroundColor:"#EDEFFF",
        opacity:1
    })
})
elem.addEventListener("mouseleave",function(dets){
    cursor.innerHTML=""
    gsap.to(cursor,{
        scale:1,
        backgroundColor:"#BEE3DB",
        opacity:0
    })
})

// rollbaseddasboardheading.addEventListener("mouseenter",function(dets){
//     // cursor.innerHTML = "<p style='color: red; font-weight: bold; font-size:5px'>Isn't Great?</p>"
//     cursor.innerHTML = "<span style='color: red; font-size:5px ; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'>Isn't Great?</span>";
//     gsap.to(cursor,{
//         scale:6,
//         backgroundColor:"#ffffff",
//         // borderRadius: "0",
//         opacity:1
//     })
// })
// rollbaseddasboardheading.addEventListener("mouseleave",function(dets){
//     gsap.to(cursor,{
//         opacity:0
//     })
// })

// roleintrocards.addEventListener("mouseenter",function(dets){
//     cursor.innerHTML=""
//     gsap.to(cursor,{
//         scale:3,
//         backgroundColor:"#537f84",
//         color:"#537f84",
//         // borderRadius: "0",
//         opacity:1
//     })
// })
// roleintrocards.addEventListener("mouseleave",function(dets){
//     gsap.to(cursor,{
//         opacity:0
//     })
// })


introcardteacher.addEventListener("mouseenter", function(dets) {
    border: "2px solid #ffffff",
    cursor.innerHTML = "<span style='color: white; font-size: 3px; display: inline-block; padding:7px; line-height: 1.5;' ><ul style='margin: 0; padding: 0; list-style-type: none;'><li>Launch Courses</li><li>Take Quizzes</li><li>Do Assessments</li><li>Chat Anytime</li></ul></span>";
    gsap.to(cursor, {
        scale: 5,
        backgroundColor: "#304065",
        opacity: 1,
        delay:0.125,
        borderRadius: "0px",
        x: 0, // Resetting any translate X
        y: 0  // Resetting any translate Y
    });
});
introcardteacher.addEventListener("mousemove",function(dets){
    gsap.to(cursor,{
        x:dets.x,
        y:dets.y,
        duration:1,
        ease:"back.out",
        opacity:1
    })
})
introcardteacher.addEventListener("mouseleave",function(dets)
{
    cursor.innerHTML = ""
    gsap.to(cursor,{
        scale:0,
        delay:0.125,
        opacity:0,
        borderRadius: "50px",
    })
})


introcardstudent.addEventListener("mouseenter", function(dets) {
    border: "2px solid #ffffff",
    cursor.innerHTML = "<span style='color: white; font-size: 3px; display: inline-block; padding:7px; line-height: 1.5;' ><ul style='margin: 0; padding: 0; list-style-type: none;'><li>Follow Courses</li><li>Give Quizzes</li><li>Do Assessments</li><li>Chat Anytime</li></ul></span>";
    gsap.to(cursor, {
        scale: 5,
        backgroundColor: "#304065",
        opacity: 1,
        delay:0.125,
        borderRadius: "0px",
        x: 0, // Resetting any translate X
        y: 0  // Resetting any translate Y
    });
});
introcardstudent.addEventListener("mousemove",function(dets){
    gsap.to(cursor,{
        x:dets.x,
        y:dets.y,
        duration:1,
        ease:"back.out",
        opacity:1
    })
})
introcardstudent.addEventListener("mouseleave",function(dets)
{
    cursor.innerHTML = ""
    gsap.to(cursor,{
        scale:0,
        opacity:0,
        delay:0.125,
        borderRadius: "50px",
    })
})
introcardguardian.addEventListener("mouseenter", function(dets) {
    border: "2px solid #ffffff",
    cursor.innerHTML = "<span style='color: white; font-size: 3px; display: inline-block; padding:7px; line-height: 1.5;' ><ul style='margin: 0; padding: 0; list-style-type: none;'><li>Parental Monitering</li><li>Chat Anytime</li><li>Do Assessments</li></ul></span>";
    gsap.to(cursor,{
        scale: 5,
        backgroundColor: "#304065",
        opacity: 1,
        delay:0.125,
        borderRadius: "0px",
        x: 0, // Resetting any translate X
        y: 0  // Resetting any translate Y
    });
});
introcardguardian.addEventListener("mousemove",function(dets){
    gsap.to(cursor,{
        x:dets.x,
        y:dets.y,
        duration:1,
        ease:"back.out",
        opacity:1
    })
})
introcardguardian.addEventListener("mouseleave",function(dets)
{
    cursor.innerHTML = ""
    gsap.to(cursor,{
        scale:0,
        opacity:0,
        // delay:0.125,
        borderRadius: "50px",
    })
})

/*/////////////////////////// gsap or Animations ///////////////////////////*/


function FirstPageAnimation()
{
    var tl = gsap.timeline()

    // tl.from("nav h2, nav div a",{
    //     y:-30,
    //     duration:0.1,
    //     // delay:0.5,
    //     opacity:0,
    //     stagger:0.4
    // })

    tl.from(".homePageCenterPart1 h1, .homePageCenterPart1 p",{
        x:-400,
        duration:0.5,
        opacity:0,
        stagger:0.4
    })
}
function mainmenuAnimation() {
    var tl = gsap.timeline({ repeat: -1, repeatDelay: 7 }); // repeat: -1 means infinite repeating

    tl.from("nav div a", {
      y: -30,
      duration: 0.5,
      opacity: 0,
      stagger: 0.4,
      transformOrigin: "center center", // Center origin for flip effect
      rotationY: 180 // Horizontal flip
    });
  }

  // Start the animation
  mainmenuAnimation();


FirstPageAnimation()

var tl2 = gsap.timeline({
    scrollTrigger:{
        trigger:".section2",
        scroller:"body",
        start:"top 100%",
        end:"top 0",
        scrub:2,
        smooth:0.1
    }
})
tl2.from(".benefits",{
    x:-300,
    opacity:0,
    stagger:0.4,
    duration:3,
})
tl2.from(".elem.line1.left",{
    x:-300,
    opacity:0,
    duration:1,
},"1ndline")
tl2.from(".elem.line2.right",{
    x:300,
    opacity:0,
    duration:1,
},"1ndline")
tl2.from(".elem.line3.left",{
    x:-300,
    opacity:0,
    duration:1,
},"2ndline")
tl2.from(".elem.line4.right",{
    x:300,
    opacity:0,
    duration:1,
},"2ndline")

// gsap.to(".bigtext",{
//     transform:"translateX(-600%)",
//      scrollTrigger:{
//         trigger:".divbigtext",
//         scroller:"body",
//         start:"top 30%",
//         end:"top -150",
//         duration:4,
//         scrub:2,
//         pin:true
//     }
// })





var tl3 = gsap.timeline({scrollTrigger:{

trigger:"#section1",
// markers:true,
scroller:"body",
start:"top 2%",
end:"top 70",
scrub:1,
duration:0.5,
// delay:2,

smooth:0.4
}})

// tl3.to(".highlight",{
//     // backgroundSize: "100% 100% ",
//     textDecoration: "underline",d
// })


// GSAP animation to change the circle to a rectangle
gsap.to(".scrollcirlce", {
    borderRadius: "0", // Set border radius to 0 to make it a rectangle
    opacity:0,
    x:90,
    duration: 1, // Animation duration
    scrollTrigger: {
        trigger: ".homePageCenterPart1", // Adjust the trigger if needed
        start: "top 20%", // Start the animation when the trigger is 20% into the viewport
        end: "top 30%", // End the animation when the trigger is 30% into the viewport
        scrub: 2, // Smoothly animate the changes as you scroll
        // smooth:0.4,
        color:"#00000",
        // xy:300,
    }
});


gsap.from(".roleteacherdashboard", {
    borderRadius: "0", // Set border radius to 0 to make it a rectangle
    // opacity:0,
    x:-500,
    opacity:0,
    padding:"5%",
    duration: 1, // Animation duration
    border: "3px solid black",
    scrollTrigger: {
        trigger: ".roleintrocards", // Adjust the trigger if needed
        start: "top 60%", // Start the animation when the trigger is 20% into the viewport
        end: "top 50%", // End the animation when the trigger is 30% into the viewport
        scrub: 1, // Smoothly animate the changes as you scroll
        // smooth:0.4,
        // color:"#00000",
        // xy:300,
        // markers:true,
        color:"ffff"

    }
});
gsap.from(".rolestudentdashboard", {
    borderRadius: "0", // Set border radius to 0 to make it a rectangle
    // opacity:0,
    x:-500,
    opacity:0,
    padding:"5%",
    duration: 2, // Animation duration
    border: "3px solid black",
    scrollTrigger: {
        trigger: ".roleintrocards", // Adjust the trigger if needed
        start: "top 50%", // Start the animation when the trigger is 20% into the viewport
        end: "top 30%", // End the animation when the trigger is 30% into the viewport
        scrub: 2, // Smoothly animate the changes as you scroll
        // smooth:0.4,
        // color:"#00000",
        // xy:300,
        // markers:true,
    }
});
gsap.from(".roleguardiandashboard", {
    borderRadius: "0", // Set border radius to 0 to make it a rectangle
    // opacity:0,
    x:-500,
    opacity:0,
    padding:"5%",
    duration: 3, // Animation duration
    border: "3px solid black",
    scrollTrigger: {
        trigger: ".roleintrocards", // Adjust the trigger if needed
        start: "top 45%", // Start the animation when the trigger is 20% into the viewport
        end: "top 20%", // End the animation when the trigger is 30% into the viewport
        scrub: 3, // Smoothly animate the changes as you scroll
        // smooth:0.4,
        // color:"#00000",
        // xy:300,
        // markers:true,
    }
});
