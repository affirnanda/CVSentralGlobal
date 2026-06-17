// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

Cypress.Commands.add('isiCheckoutValid', () => {

    cy.get('input[name="full_name"]')
        .type('Galang Tegar');

    cy.get('input[name="email"]')
        .type('galang@test.com');

    cy.get('input[name="phone"]')
        .type('081234567890');

    cy.get('input[name="address"]')
        .type('Alamat Testing');

    cy.get('input[name="postal_code"]')
        .type('60234');   
});

Cypress.Commands.add('isiCheckoutRentValid', () => {

    cy.isiCheckoutValid();

    cy.get('#province').select('JAWA TIMUR');

    cy.wait(2000);

    cy.get('#city').select('KAB. SIDOARJO');

    cy.wait(2000);

    cy.get('#district').select('Gedangan');

    cy.get('input[name="rent_start"]')
        .type('2027-06-20');

    cy.get('input[name="rent_end"]')
        .type('2027-06-23');

    cy.get('input[name="payment_method_id"]')
        .first()
        .check({ force: true });
});