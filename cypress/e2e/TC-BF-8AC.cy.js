describe('TC-BF-8AC', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AC Nomor WA 14 digit ditolak', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="phone"]') .clear() .type('12345678901234'); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('nomor WA tidak valid'); 
    });

});