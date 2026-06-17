describe('TC-BF-8AK', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AK Provinsi kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('#province').select(''); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan pilih provinsi anda'); 
    });

});