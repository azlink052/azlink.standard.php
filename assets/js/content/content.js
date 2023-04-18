/**
 * ============================================================
 *
 * [content]
 *
 * ============================================================
 */
// import * as azlib from '../global/azlib_light.bundle.js';
/**
 * 汎用JS クラス
 */
class ContentJS {
  constructor() {
    this.isSkip = false;
    this.isFlowAnime = false;
    this.isPopup = false;
    this.isAcc = false;
    this.isOpen = false;
    this.isAllowClose = false;
    this.isDefaultFirst = true;
    this.isScroll = true;
    this.hHeight = 0;
    this.hHeightOrg = 0;
    this.hWidth = 0;
    this.isNavMainHover = [];
    this.isNavSubHover = [];
    this.subHeights = [];
    this.resizeTimer = false;
    this.adminMargin = 0;
    this.scrTopCache = 0;
  }
  init() {
    this.isSkip = document.body.classList.contains('is-skip') ? true : false;
    this.isFlowAnime = document.body.classList.contains('is-flowAnime') ? true : false;
    this.isPopup = document.body.classList.contains('is-popup') ? true : false;
    this.isAcc = document.body.classList.contains('is-acc') ? true : false;

    // ロケーションハッシュ
    window.addEventListener('load', () => {
      if (location.hash !== '') {
        const hash = location.hash.replace('#', '');
        const target = document.getElementById(hash);
        const offset = -Number(this.hHeight);
        const targetPos = target.getBoundingClientRect().top + window.pageYOffset + offset;
        const anime = new azlib.anime({
          targets: 'html, body',
          scrollTop: targetPos,
          duration: 10,
          easing: 'easeInQuad',
          update: () => {
            const newTargetPos = target.getBoundingClientRect().top + window.pageYOffset + offset;
            if (targetPos !== newTargetPos) {
              anime.set('html, body', {
                scrollTop: () => {
                  return newTargetPos;
                },
              });
            }
          },
        });
      }
    });

    window.addEventListener('resize', () => {
      if (this.resizeTimer !== false) {
        clearTimeout(this.resizeTimer);
      }

      this.resizeTimer = setTimeout(() => {
        this.adjust();
        if (util.isChangeMode) {
          if (!util.isRespMode) {
            document.getElementById('gNavWrapper').style.display = 'block';
          } else {
            if (util.isNavOpen) document.getElementById('gNavWrapper').click();
          }
        }
      }, 500);
    });

    if (document.getElementById('js-pageTop')) {
      document.querySelector('#js-pageTop a').addEventListener('click', (e) => {
        new azlib.anime({
          targets: 'html, body',
          scrollTop: 0,
          duration: 500,
          easing: 'easeInOutQuart',
        });
      });
    }

    if (document.getElementById('gNavOpener')) {
      document.getElementById('gNavOpener').addEventListener('click', (e) => {
        if (util.isNavOpen) {
          document.getElementById('gNavOpener').classList.remove('is-navOpen');
          document.body.classList.remove('is-navOpen');
          if (util.isRespMode) {
            document.body.style.top = 'auto';
            window.scrollTo(0, this.scrTopCache);
          }
          util.isNavOpen = false;
        } else {
          util.isNavOpen = true;
          if (util.isRespMode) {
            this.scrTopCache = util.scrTop;
            this.adjust();
            document.body.style.top = `-${this.scrTopCache}px`;
          }
          document.getElementById('gNavOpener').classList.add('is-navOpen');
          document.body.classList.add('is-navOpen');
        }
      });
    }

    document.querySelectorAll('#gNavWrapper a').forEach((v, i) => {
      v.addEventListener('click', (e) => {
        if (util.isNavOpen) document.getElementById('gNavOpener').click();
      });
    });

    window.addEventListener('scroll', (e) => {
      if (document.body.classList.contains('is-navOpen')) {
        e.preventDefault();
        return false;
      }
    });

    this.hHeightOrg = document.getElementById('siteHeader') ? document.getElementById('siteHeader').clientHeight : 0;

    const rplSPImg01 = new azlib.ReplaceImageSP('.rplSPImg', {
      spBreakPoint: util.spBreakPoint,
    });

    if (this.isPopup) {
      const popup = new azlib.PopupAdjust('.popupBtItem', {
        onComplete: () => {
          console.log('loaded');
        },
      });
    }

    if (this.isFlowAnime) {
      // flowVox
      const flowVox = new azlib.FlowVox('.flowVox', {
        // isRepeat: true,
        // per: 0.25,
        duration: 1000,
        easing: 'easeInOutQuad',
      });
    }

    const acc01 = new azlib.SimpleAccordion();

    this.adjust().then(() => this.runIntro());
  }
  async adjust() {
    this.hHeight = document.getElementById('siteHeader').clientHeight;
    this.adminMargin = parseInt(getComputedStyle(document.getElementsByTagName('html')[0]).marginTop);
    util.sScroll(-(Number(this.adminMargin) + Number(this.hHeight)), 500, 'easeInQuad');

    if (util.isRespMode) {
      if (document.getElementById('gNavWrapper')) document.getElementById('gNavWrapper').style.height = `${util.wHeight}px`;
    } else {
      if (document.getElementById('gNavWrapper')) document.getElementById('gNavWrapper').style.height = 'auto';
    }

    if (document.getElementById('siteTitleVox')) {
      document.getElementById('siteTitleVox').style.height = `${util.wHeight}px`;
    }

    this.adjustHeader();

    return 'resolve';
  }
  runIntro() {
    if (this.isSkip) return;

    // document.getElementById('wrapper').style.visibility = 'visible';

    new azlib.anime({
      targets: '#loading',
      opacity: [1, 0],
      complete: (anim) => {
        if (document.getElementById('loading')) {
          document.getElementById('loading').style.display = 'none';
        }
      },
    });

    new azlib.anime({
      targets: '#wrapper',
      opacity: 1,
      delay: 400,
      duration: 250,
      easing: 'linear',
      complete: (anim) => {
        this.isDefaultFirst = false;
        document.body.classList.add('is-finishedIntro');
      },
    });
  }
  adjustHeader() {}
}
/**
 * Home用JSクラス
 */
class HomeJS {
  constructor() {
    this.rTimer = false;
    this.isFirst = true;
    this.homeDir = HOME_DIR;
    this.storySlider = {
      current: 0,
      length: 0,
      item_w: 0,
      elem: false,
      wrapper: false,
      isAllowChange: true,
    };
  }
  init() {
    window.addEventListener('resize', () => {
      if (this.rTimer !== false) {
        clearTimeout(Number(this.rTimer));
      }

      this.rTimer = window.setTimeout(() => {
        this.adjust();
        if (util.isChangeMode) {
          this.adjust();
        }
      }, 500);
    });

    // MV
    // document
    //   .querySelectorAll('#js-mvSlider li')
    //   .forEach((v: HTMLElement, i: number) => {
    //     const SRC = v.querySelector('img').src;
    //     // console.log(src)
    //     if (SRC) {
    //       v.style.backgroundImage = `url(${SRC})`;
    //       v.querySelector('img').remove();
    //     }
    //   });

    const mvSlider = new azlib.FadeSlider('#js-mvSlider', {
      speed: 3000,
      pause: 4000,
    });

    document.getElementById('js-newsSlider').innerHTML = '';
    document.getElementById('js-newsSlider').classList.add('is-loading');

    // STORY スライダ
    // const storySlider = new azlib.SimpleSlider('#js-storySlider', {
    //   ctrl: true,
    //   pager: true,
    //   speed: 500,
    //   pause: 3000,
    //   isAuto: false,
    //   isLoop: false,
    //   // cloneCount: 10,
    //   // isDebug: true
    // });

    this.adjust().then(() => this.runIntro());
    // お知らせ
    (async () => {
      const response = await fetch('/content/wp-json/wp/v2/posts?per_page=5', {
        cache: 'no-cache',
      });
      const res = await response.json();
      // console.log(res);
      if (res.length > 0) {
        res.forEach((v, i) => {
          const dateObj = (() => {
            const t = new Date(v.date);
            return [`${t.getFullYear()}-${t.getMonth() + 1}-${t.getDate()} ${t.getHours()}:${t.getMinutes()}:${t.getSeconds()}`, `${t.getFullYear()}.${t.getMonth() + 1}.${t.getDate()}`];
          })();
          const src = `
            <article>
              <a href='/news/${v.id}'>
                <time datetime='${dateObj[0]}'>${dateObj[1]}</time>
                <h3 class='entryTitle'>
                  ${v.title.rendered}
                </h3>
              </a>
            </article>
          `;
          document.getElementById('js-newsSlider').insertAdjacentHTML('beforeend', src);
        });
        if (res.length > 1) {
          document.getElementById('js-newsSlider').classList.add('is-slide');
          if (res.length === 2) {
            // 二件しかない場合は先頭の記事を複製
            const elem = document.getElementById('js-newsSlider').querySelector('article').cloneNode(true);
            document.getElementById('js-newsSlider').append(elem);
          }
          const newsSlider = new azlib.FadeSlider('#js-newsSlider', {
            speed: 0,
            pause: 5000,
            isChangeOpacity: false,
            onSliderLoad: () => {
              document.getElementById('js-newsSlider').querySelectorAll('article')[0].classList.add('slide-active');
            },
            onSlideBefore: (oldIndex, newIndex) => {
              // console.log(oldIndex, newIndex);
            },
            onSlideAfter: (oldIndex, newIndex) => {
              // console.log(oldIndex, newIndex);
            },
          });
        }
        document.getElementById('js-newsSlider').classList.remove('is-loading');
      } else {
        document.getElementById('news').remove();
      }
    })();
    // イベントの表示
    (async () => {
      const response = await fetch('/apps/get_events.php?number=5', {
        cache: 'no-cache',
      });
      const res = await response.json();
      // console.log(res);
      if (res.count > 0) {
        res.posts.forEach((v, i) => {
          const date2 = v.date2 ? `<br class="spDspNone">〜<time datetime="${v.datetime2}">${v.date2}</time>` : '';
          const src = `
            <article>
              <div class="time">
                <time datetime="${v.datetime}">${v.date}</time>
                ${date2}
              </div>
              <div class="txt">
                <h4 class="eventTitle">${v.title}</h4>
                ${v.content}
              </div>
            </article>
          `;
          document.getElementById('js-eventContentVox').insertAdjacentHTML('beforeend', src);
        });
      } else {
        document.getElementById('js-eventContentVox').insertAdjacentHTML('beforeend', '<p>しばらくイベントの予定はありません。</p>');
      }
    })();
    // rellax
    if (document.body.classList.contains('is-rx')) {
      window.addEventListener(
        'load',
        () => {
          const rellax = new Rellax('.rellax', {
            // speed: -2,
            // center: true,
            // breakpoints: [320, 768, 2500]
          });
        },
        {
          once: true,
        }
      );
    }
  }
  async adjust() {
    document.getElementById('js-mvSlider').style.height = `${util.wHeight}px`;
    return 'resolve';
  }
  runIntro() {
    this.isFirst = false;
    return;

    Object.assign(document.getElementById('wrapper').style, {
      visibility: 'visible',
      opacity: 0,
    });
    new azlib.anime({
      targets: '#wrapper',
      opacity: 1,
      duration: 500,
      easing: 'linear',
    });
  }
}
/**
 * Request用JSクラス
 */
class RequestJS {
  constructor() {
    this.rTimer = false;
    this.isFirst = true;
    this.errBgColor = 'rgb(249, 205, 209)';
  }
  init() {
    if (document.body.classList.contains('form')) {
      document.querySelectorAll('.submitItem').forEach((v, i) => {
        v.addEventListener('submit', (e) => {
          v.querySelector('button').disabled = true;
        });
      });
      if (document.body.classList.contains('checked')) {
        document.forms.contactForm.addEventListener('submit', (e) => {
          e.preventDefault();
          return false;
          // document.forms[
          //   'contactForm'
          // ].action = `${HOME_DIR}request/contact/thanks#contactForm'`;
        });
        document.getElementById('js-submit').addEventListener('click', (e) => {
          const dir = e.currentTarget.getAttribute('data-dir');
          document.forms['contactForm'].action = `${HOME_DIR}request/${dir}/thanks#mainArt'`;
          document.forms['contactForm'].submit();
        });
        document.getElementById('js-back').addEventListener('click', () => {
          document.forms['contactForm'].entryPg.value = '';
          document.forms['contactForm'].submit();
        });
      }
    }
    // エラー
    if (document.body.classList.contains('error')) {
      document.querySelectorAll('.caution').forEach((v, i) => {
        v.closest('.formItem').style.backgroundColor = this.errBgColor;
      });
    }
  }
}
/**
 * インスタンス化
 */
const util = new azlib.Utilities({
  spBreakPoint: 767,
});
const contentJS = new ContentJS();
const homeJS = new HomeJS();
const contactJS = new ContactJS();
/**
 * 実行
 */
window.addEventListener('DOMContentLoaded', () => {
  util.init();
  contentJS.init();
  if (document.body.classList.contains('home')) {
    homeJS.init();
  }
  if (document.body.classList.contains('contact')) {
    contactJS.init();
  }
  const lazyBg = new azlib.LazyLoadBg('.js-lazyBg');
});
