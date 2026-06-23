describe('TC-BF-8AP', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AP Metode pembayaran kosong', () => { 
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

        cy.get('#province').select('JAWA TIMUR');

        cy.wait(2000);

        cy.get('#city').select('KAB. SIDOARJO');

        cy.wait(2000);

        cy.get('#district').select('Gedangan');

        cy.get('input[name="rent_start"]')
        .type('2027-06-20');

        cy.get('input[name="rent_end"]')
        .type('2027-06-23');

        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan pilih metode pembayaran anda'); 
    });

});