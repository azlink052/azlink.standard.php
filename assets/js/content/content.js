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
    this.isNoCueOffset = false;
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
    this.isFlowAnime = document.body.classList.contains('is-flowAnime')
      ? true
      : false;
    this.isPopup = document.body.classList.contains('is-popup') ? true : false;
    this.isNoCueOffset = document.body.classList.contains('is-noCueOffset')
      ? true
      : false;

    // ロケーションハッシュ
    window.addEventListener('load', () => {
      if (location.hash !== '' && !this.isNoCueOffset) {
        const hash = location.hash.replace('#', '');
        const target = document.getElementById(hash);
        const offset = -Number(this.hHeight);
        const targetPos =
          target.getBoundingClientRect().top + window.pageYOffset + offset;
        const anime = new azlib.anime({
          targets: 'html, body',
          scrollTop: targetPos,
          duration: 10,
          easing: 'easeInQuad',
          complete: () => {
            const newTargetPos =
              target.getBoundingClientRect().top + window.pageYOffset + offset;
            // console.log(targetPos, newTargetPos)
            if (targetPos !== newTargetPos) {
              new azlib.anime({
                targets: 'html, body',
                scrollTop: newTargetPos,
                duration: 10,
                easing: 'linear',
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
          window.location.reload();
          // if (!util.isRespMode) {
          //   document.getElementById('gNavWrapper').style.display = 'block';
          // } else {
          //   if (util.isNavOpen) document.getElementById('gNavWrapper').click();
          // }
        }
      }, 500);
    });

    if (document.getElementById('js-pageTopVox')) {
      document
        .querySelector('#js-pageTopVox button')
        .addEventListener('click', (e) => {
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

    this.hHeightOrg = document.getElementById('siteHeader')
      ? document.getElementById('siteHeader').clientHeight
      : 0;

    const rplSPImg01 = new azlib.ReplaceImageSP('.rplSPImg', {
      spBreakPoint: util.spBreakPoint,
    });

    if (this.isPopup) {
      const popup = new azlib.PopupAdjust('.popupBtItem', {
        onComplete: () => {
          console.log('loaded');
        },
      });
      document.querySelectorAll('.popupBtItem.movie').forEach((v, i) => {
        v.addEventListener('click', (e) => {
          const movie = v.getAttribute('data-movie');
          const src = `<iframe src="https://www.youtube.com/embed/${movie}?autoplay=1&rel=0" frameborder="0"
          allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
          document
            .querySelector('#popupWrapperMovie .content')
            .insertAdjacentHTML('beforeend', src);
        });
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

    const tabIndex = util.qsParm['tabIndex']
      ? parseInt(util.qsParm['tabIndex'])
      : 0;
    const simpleTabs = new azlib.SimpleTab('.tabVoxWrapper', {
      current: tabIndex,
      isAdjustHeight: false,
      onComplete: () => {
        console.log('tabs loaded');
      },
    });

    this.adjust().then(() => this.runIntro());
  }
  async adjust() {
    new Promise((resolve, reject) => {
      this.hHeight = document.getElementById('siteHeader').clientHeight;
      this.adminMargin = parseInt(
        getComputedStyle(document.getElementsByTagName('html')[0]).marginTop
      );
      util.sScroll(
        -(Number(this.adminMargin) + Number(this.hHeight)),
        500,
        'easeInQuad'
      );

      if (util.isRespMode) {
        if (document.getElementById('gNavWrapper'))
          document.getElementById(
            'gNavWrapper'
          ).style.height = `${util.wHeight}px`;
      } else {
        if (document.getElementById('gNavWrapper'))
          document.getElementById('gNavWrapper').style.height = 'auto';
      }

      if (document.getElementById('siteTitleVox')) {
        document.getElementById(
          'siteTitleVox'
        ).style.height = `${util.wHeight}px`;
      }

      this.adjustHeader();

      resolve();
    });
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
class Home {
  constructor() {
    this.rTimer = false;
    this.isFirst = true;
  }
  init() {
    this.adjust().then(() => console.log('home init'));
  }
  async adjust() {
    new Promise((resolve, reject) => {
      resolve();
    });
  }
  runIntro() {
    this.isFirst = false;
    return;
  }
}
/**
 * Form用JSクラス
 */
class Form {
  constructor() {
    this.rTimer = false;
    this.isFirst = true;
    this.errBgColor = 'rgb(249, 205, 209)';
    // file
    this.isAllowChangeFile = false;
    this.events = ['change', 'drop'];
    this.uploadApp = `${HOME_DIR}apps/upload_temp_file.php`;
    this.deleteApp = `${HOME_DIR}apps/delete_temp_file.php`;
    this.fileSizeLimit = UPLOAD_IMGSIZELIMIT;
    this.fileCountLimit = xxx_FILELENGTH_LIMIT;
    this.fileField;
    this.previewImg;
    this.entryFileField;
  }
  init() {
    document.querySelectorAll('.submitItem').forEach((v, i) => {
      v.addEventListener('submit', (e) => {
        v.querySelectorAll('button, input').forEach((v) => (v.disabled = true));
      });
    });
    if (document.body.classList.contains('checked')) {
      document.forms.contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        return false;
      });
      document.getElementById('js-submit').addEventListener('click', (e) => {
        const dir = e.currentTarget.getAttribute('data-dir');
        document.forms['contactForm'].action = `${HOME_DIR}${dir}`;
        document.forms['contactForm'].submit();
      });
      document.getElementById('js-back').addEventListener('click', () => {
        document.forms['contactForm'].entryPg.value = '';
        document.forms['contactForm'].submit();
      });
    }
    // エラー
    if (document.body.classList.contains('error')) {
      document.querySelectorAll('.caution').forEach((v, i) => {
        v.closest('.formItem').style.backgroundColor = this.errBgColor;
      });
    }
    // file
    this.fileField = document.getElementById('js-uploadFile');
    this.previewImg = document.getElementById('js-previewImg');
    this.entryFileField = document.getElementById('js-entryFileField');

    this.previewImg?.addEventListener(
      'click',
      async (e) => {
        e.preventDefault();
        if (e.target.classList.contains('deleteTempFile')) {
          if (window.confirm('削除しますか？')) {
            if (!this.isAllowChangeFile) return;
            this.isAllowChangeFile = false;
            const formData = new FormData();
            formData.append('deleteFile', e.target.dataset.file);
            const res = await this.deleteTempFile(formData);
            e.target.closest('.tmpFile').remove();
            this.entryFileField
              .querySelector(`input[value="${e.target.dataset.file}"]`)
              .remove();
            this.isAllowChangeFile = this.getAllowChangeFile();
            this.toggleFileField();
          }
        }
      },
      false
    );
    this.fileField?.addEventListener(
      'dragover',
      (e) => {
        e.preventDefault();
      },
      false
    );
    // アップロード
    this.events.forEach((event) => {
      this.fileField?.addEventListener(
        event,
        (e) => {
          e.preventDefault();
          // console.log(this.isAllowChangeFile);
          if (!this.isAllowChangeFile) return;
          this.isAllowChangeFile = false;

          const files =
            e.type === 'change' ? e.target.files : e.dataTransfer.files;
          if (files.length) {
            document.body.classList.add('is-loading');

            let i = 0;
            (async () => {
              for (const file of files) {
                if (file.size) {
                  // 容量制限
                  if (file.size > this.fileSizeLimit) {
                    alert(
                      `ファイルサイズが${this.fileSizeLimit}バイトを超えているものがあります`
                    );
                    this.fileField.value = '';
                  } else {
                    const formData = new FormData();
                    formData.append('entryIndex', i);
                    formData.append('entryFile', file);
                    formData.append('uploadDir', 'contact');
                    const res = await this.uploadTemp(formData);
                    // プレビューに追加
                    const thumb = res.body.thumb
                      ? `<img src="${HOME_DIR}uploads/tmp/${res.body.thumb}">`
                      : `<img src="${ASSETS_DIR}images/content/content/ico_file.svg" class="noimg">`;
                    this.previewImg.insertAdjacentHTML(
                      'beforeend',
                      `<div class="tmpFile">
                          <figure>
                            <button type="button" class="deleteTempFile" data-file="${res.body.contents}" data-name="entryFile${i}">削除する</button>
                            <a href="${HOME_DIR}uploads/tmp/${res.body.contents}" class="viewFile" target="_blank">${thumb}</a>
                          </figure>
                        </div>`
                    );
                    // 　form へ追加
                    this.entryFileField.insertAdjacentHTML(
                      'beforeend',
                      `<input type="hidden" name="entryFile1[]" class="entryFile" value="${res.body.contents}" id="entryFile${i}">`
                    );
                    i++;
                  }
                }
              }
              this.isAllowChangeFile = this.getAllowChangeFile();
              this.toggleFileField();
            })();
          }
        },
        false
      );
    });
    this.isAllowChangeFile = true;
  }
  async uploadTemp(formData) {
    const response = await fetch(this.uploadApp, {
      method: 'POST',
      body: formData,
      cache: 'no-cache',
    });
    const res = await response.json();
    return res;
  }
  getAllowChangeFile() {
    return this.previewImg.querySelectorAll('.tmpFile').length <
      this.fileCountLimit
      ? true
      : false;
  }
  toggleFileField() {
    this.fileField.value = '';
    this.fileField.disabled = this.isAllowChangeFile ? false : true;
  }
  async deleteTempFile(formData) {
    // console.log(file, mode, name, this.deleteApp)
    const response = await fetch(this.deleteApp, {
      method: 'POST',
      body: formData,
      cache: 'no-cache',
    });
    const res = await response.json();
    return res;
  }
  loadFile(file) {
    return new Promise((resolve) => {
      const reader = new FileReader();

      reader.onload = (event) => {
        resolve(event.target.result);
      };

      reader.readAsDataURL(file);
    });
  }
}
/**
 * インスタンス化
 */
const util = new azlib.Utilities({
  spBreakPoint: 767,
});
const contentJS = new ContentJS();
const homeJS = new Home();
const formJS = new Form();
/**
 * 実行
 */
window.addEventListener('DOMContentLoaded', () => {
  util.init();
  contentJS.init();
  if (document.body.classList.contains('home')) {
    homeJS.init();
  }
  if (document.body.classList.contains('form')) {
    formJS.init();
  }
  const lazyBg = new azlib.LazyLoadBg('.js-lazyBg');
});
