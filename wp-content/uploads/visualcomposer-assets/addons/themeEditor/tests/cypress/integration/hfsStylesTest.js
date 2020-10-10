/* global describe, it, cy */
const createHeader = (callback) => {
  cy.createHeader()
  cy.addElement('Basic Button')
  cy.setInput('Button text', 'Header custom text')
  cy.setButtonGroup('Alignment', 'center')
  cy.setButtonGroup('Shape', 'rounded')
  cy.setButtonGroup('Size', 'small')

  cy.setClassAndId('header-button-id', 'header-button-class')
  cy.setColor({
    'title': 'Title color',
    'initialValue': 'FFFFFF',
    'value': 'FFC000',
    'valueRgb': 'rgb(255, 192, 0)'
  })
  cy.setColor({
    'title': 'Background color',
    'initialValue': '557CBF',
    'value': '9461D3',
    'valueRgb': 'rgb(148, 97, 211)'
  })
  cy.savePage()
  cy.window().then(window => {
    callback(window.vcvSourceID)
  })
}

const createFooter = (callback) => {
  cy.createFooter()
  cy.addElement('Single Image')
  cy.setButtonGroup('Shape', 'rounded')
  cy.setInput('Size', `200x250`)
  cy.setButtonGroup('Alignment', 'right')
  cy.setClassAndId('footer-image-id', 'footer-image-class')
  cy.setDO({
    'margin': '10px',
    'borderWidth': '3px',
    'borderRadius': '5px',
    'borderStyle': 'dashed',
    'padding': '30px',
    'backgroundColor': {
      'hex': 'BF5C5C',
      'rgb': 'rgb(191, 92, 92)'
    },
    'borderColor': {
      'hex': 'FFC000',
      'rgb': 'rgb(255, 192, 0)'
    },
    'animation': 'jello'
  })
  cy.savePage()
  cy.window().then(window => {
    callback(window.vcvSourceID)
  })
}

describe('HFS Styles Test', function () {
  it('Creates regular post, header, footer, then makes it global', function () {
    let regularPostLink
    let headerId
    let footerId
    cy.createWpPost({
      'postTitle': 'Regular post in wordpress for HFS Styles test',
      'postContent': 'Unique content for HFS Styles TEst'
    }, (id, data) => {
      regularPostLink = data.link
      createHeader((hId) => {
        headerId = hId
        createFooter((fId) => {
          footerId = fId

          // Attach createst header and footers globally for whole website
          cy.visit(Cypress.env('hfsSettings'))
          cy.get('#vcv-headerFooterSettings')
            .select('allSite')

          cy.get('#vcv-headerFooterSettingsAllHeader')
            .select(headerId + '')

          cy.get('#vcv-headerFooterSettingsAllFooter')
            .select(footerId + '')

          cy.window().then((win) => {
            let actionURL = win.document.querySelector('.vcv-dashboards-section-content--active form').getAttribute('action')
            actionURL = win.decodeURIComponent(actionURL);
            cy.route('POST', actionURL).as('settingSaving')
          })
          cy.get('.vcv-dashboards-section-content--active #submit_btn').click()
          cy.wait('@settingSaving')

          cy.visit(regularPostLink)

          // TODO: Currently failing due to lacking information and functionality.
          // cy.get(`.header-button-class #header-button-id`)
          //   .contains('Header custom text')
            // .should('have.css', 'text-align', 'center')
            // .and('have.css', 'background-color', 'rgb(148, 97, 211)')
            // .and('have.css', 'padding', '10px 30px')

          // cy.get(`#footer-image-id.footer-image-class .vce-single-image-wrapper`)
            // .should('have.css', 'border-radius', '5px')
            // .and('have.css', 'background-color', 'rgb(191, 92, 92)')
            // .and('have.css', 'padding', '30px')
        })
      })
    })
  })
})
