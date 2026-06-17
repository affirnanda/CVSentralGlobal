describe('TC-BF-8AD', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AD Nomor WA kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="phone"]').clear(); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan input nomor whatsapp anda'); 
    });

});