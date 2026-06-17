describe('TC-BF-8AB', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AB Nomor WA 8 digit ditolak', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="phone"]') .clear() .type('12345678'); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('nomor WA tidak valid'); 
    });

});