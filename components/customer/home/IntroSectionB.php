<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Attorney Join Years</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <style>

    Body {
        font-family: "Times New Roman", Times, serif;
        background: linear-gradient(to bottom right, #efe8dd, #dcd4c8); 
        color: #333;
        padding: 20px;
    }


    h1, h2, h3, h2.subtitle {
        font-style: italic;
        text-align: center;
    }

    h1 {
        font-size: 2rem;
        color: #4a3b32;
        margin-bottom: 5px;
    }

    h2.subtitle {
        font-size: 1.2rem;
        color: #6d6055;
        margin-bottom: 20px;
    }

    .introSectionContainer {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 80%;
        max-width: 1100px;
        margin: 30px auto;
    }

    .paragraph {
        text-align: center;
        width: 70%;
        margin: 0 auto;
        color: #5f5147;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .mySwiper, .mySwiper2 {
        margin: 20px auto;
        max-width: 1100px;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide span {
        font-size: 1rem;
        color: #4a3b32;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        border: 1px solid #4a3b32;
        background: #f6f1eb;
        cursor: pointer;
    }

    .swiper-slide span:hover {
        background-color: #4a3b32;
        color: #fff;
    }

    .timeline-line {
        position: relative;
        margin: 30px auto;
        width: 80%;
        height: 4px;
        background-color: #4a3b32;
        border-radius: 2px;
    }

    .TimelineBlock {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background-color: #fffdfb;
        border-radius: 8px;
        box-shadow: 0px 3px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 90%;
        max-width: 280px;
    }

    .TimelineBlock:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .boxTop {
        padding: 15px;
        background: #4a3b32;
        color: #fff;
        width: 100%;
        border-radius: 8px 8px 0 0;
    }

    .boxTop h3 {
        font-size: 1.1rem;
        margin-bottom: 5px;
        font-weight: normal;
        letter-spacing: 0.5px;
    }

    .boxTop h2 {
        font-size: 1.4rem;
        margin-bottom: 10px;
        font-weight: normal;
    }

    .boxTop p {
        font-size: 0.9rem;
        color: #d8d2cd;
        line-height: 1.4;
    }

    .boxBottom {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 12px;
        background: #f6f1eb;
    }

    .boxBottom img {
        width: 100%;
        max-height: 320px;
        object-fit: cover;
        border-radius: 5px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .boxBottom img:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .swiper-scrollbar {
        background-color: #f2eee9;
        height: 8px;
        border-radius: 4px;
    }

    .swiper-scrollbar-drag {
        background-color: #4a3b32;
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        h1 {
        font-size: 1.5rem;
        }

        h2.subtitle {
        font-size: 1rem;
        }

        .paragraph {
        width: 90%;
        font-size: 0.9rem;
        }

        .mySwiper2 .swiper-slide {
        flex-direction: column;
        }

        .swiper-slide span {
        font-size: 0.9rem;
        padding: 5px 10px;
        }

        .TimelineBlock {
        max-width: 250p
        }

        .boxBottom img {
        max-height: 250px;
        }
    }

  </style>
</head>
<body>
  <div class="introSectionContainer">
    <h1 class="title">Meet Our Attorneys</h1>
    <h2 class="subTitle">Professional Legal Advisors</h2>
    <p class="paragraph">
      Our team of attorneys has years of experience across various fields of law. Explore their profiles to learn more about their expertise and achievements.
    </p>
  </div>

  <div thumbsSlider="" class="swiper mySwiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><span>2018</span></div>
      <div class="swiper-slide"><span>2019</span></div>
      <div class="swiper-slide"><span>2019</span></div>
      <div class="swiper-slide"><span>2020</span></div>
      <div class="swiper-slide"><span>2021</span></div>
      <div class="swiper-slide"><span>2021</span></div>
      <div class="swiper-slide"><span>2022</span></div>
      <div class="swiper-slide"><span>2022</span></div>
      <div class="swiper-slide"><span>2022</span></div>
      <div class="swiper-slide"><span>2023</span></div>
    </div>
  </div>

  <div class="timeline-line"></div>

  <div class="swiper mySwiper2">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2018</h3>
            <h2>Selin Doğan</h2>
            <p>An experienced corporate attorney with expertise in corporate law and governance.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_woman1.jpg" alt="Selin Doğan" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2019</h3>
            <h2>Mehmet Çelik</h2>
            <p>Defends clients in criminal cases with a strong track record of success in trials.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_man1.jpg" alt="Mehmet Çelik" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2019</h3>
            <h2>Elif Demir</h2>
            <p>Assists individuals and businesses with immigration-related matters and visas.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_woman2.jpg" alt="Elif Demir" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2020</h3>
            <h2>Fatma Öz</h2>
            <p>Specialized in immigration law.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_woman3.jpg" alt="Fatma Öz" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2021</h3>
            <h2>Ayşe Kara</h2>
            <p>Specialized in family law, including divorce, custody disputes, and marital agreements.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_woman4.jpg" alt="Ayşe Kara" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2021</h3>
            <h2>Burak Öztürk</h2>
            <p>Experienced in corporate tax planning and compliance under tax law.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_man2.jpg" alt="Burak Öztürk" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2021</h3>
            <h2>Zeynep Şahin</h2>
            <p>Focuses on environmental regulations and sustainable development.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_woman5.jpg" alt="Zeynep Şahin" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2022</h3>
            <h2>Emre Arslan</h2>
            <p>Specialist in labor disputes, employment contracts, and workplace law.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_man4.jpg" alt="Emre Arslan" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2022</h3>
            <h2>Gamze Kılıç</h2>
            <p>Expert in real estate transactions, property disputes, and related legal matters.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorneywoman6.jpg" alt="Gamze Kılıç" />
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="TimelineBlock">
          <div class="boxTop">
            <h3>2023</h3>
            <h2>Hakan Güneş</h2>
            <p>Advises on technology-related legal matters, including intellectual property and privacy law.</p>
          </div>
          <div class="boxBottom">
            <img src="/frontend/pages/images/attorneys/attorney_man5.jpg" alt="Hakan Güneş" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="barBox">
    <div class="swiper-scrollbar"></div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".mySwiper", {
      loop: false,
      spaceBetween: 0,
      slidesPerView: 5,
      mousewheel: true,
    });

    var swiper2 = new Swiper(".mySwiper2", {
      loop: false,
      spaceBetween: 10,
      slidesPerView: 3,
      centeredSlides: false,
      mousewheel: true,
      speed: 1600,
      thumbs: {
        swiper: swiper,
      },
      scrollbar: {
        el: ".swiper-scrollbar",
      },
      on: {
        slideChangeTransitionStart: function () {

          document.querySelectorAll(".mySwiper2 .swiper-slide").forEach((slide) => {
            slide.style.transform = "scale(1)";
            slide.style.transition = "transform 0.3s ease";
          });

          const activeSlide = this.slides[this.activeIndex];
          if (activeSlide) {
            activeSlide.style.transform = "scale(1.1)";
            activeSlide.style.transition = "transform 0.3s ease";
          }
        },
      },
    });
  </script>
</body>
</html>