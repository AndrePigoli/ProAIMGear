-- Create database (Run this separately first)
-- CREATE DATABASE proaim_gear;
-- USE proaim_gear;

-- Create categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id INT NOT NULL,
    featured TINYINT(1) NOT NULL DEFAULT 0,
    image VARCHAR(255) NOT NULL,
    image_2 VARCHAR(255),
    image_3 VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Create admin_users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create contact_messages table
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    read_status TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default categories
INSERT INTO categories (name) VALUES
('Mouses'),
('Teclados'),
('Mousepads');

-- Insert demo admin user (password: admin123)
INSERT INTO admin_users (username, password, email) VALUES
('admin', '$2y$10$uJ3.2nJHYIMb1a1Q.Ufw9ea2MNYyYo7jFYNw6rPKEWOp4hOFUdoMK', 'admin@proaimgear.com');

-- Insert demo products
INSERT INTO products (name, description, price, stock, category_id, featured, image) VALUES
('ProAim X1 Gaming Mouse', 'Mouse gamer com sensor ótico de alta precisão, 16000 DPI, 8 botões programáveis e iluminação RGB personalizável.\n\nIdeal para jogos FPS e MOBA, o X1 oferece respostas ultra-rápidas e controle preciso em qualquer superfície.\n\nCaracterísticas:\n- Sensor ótico de 16000 DPI\n- Switches mecânicos com durabilidade de 50 milhões de cliques\n- Iluminação RGB customizável\n- Peso ajustável\n- Polling rate de 1000Hz', 299.90, 25, 1, 1, 'https://images.pexels.com/photos/2115257/pexels-photo-2115257.jpeg'),

('ProAim K1 Teclado Mecânico', 'Teclado mecânico gamer com switches Blue, iluminação RGB por tecla, anti-ghosting completo e teclas macro programáveis.\n\nConstruído com estrutura de alumínio para maior durabilidade e estabilidade durante as sessões de jogo mais intensas.\n\nCaracterísticas:\n- Switches mecânicos Blue\n- Estrutura em alumínio\n- Iluminação RGB por tecla\n- N-key rollover\n- Software de personalização\n- Apoio de pulso destacável', 459.90, 15, 2, 1, 'https://images.pexels.com/photos/1772123/pexels-photo-1772123.jpeg'),

('ProAim Speed XL Mousepad', 'Mousepad de tamanho XL (900x400mm) com superfície de tecido de alta densidade para movimentos precisos e rápidos.\n\nBorda costurada para evitar desgaste e base de borracha antiderrapante que mantém o mousepad firmemente no lugar durante o jogo.\n\nCaracterísticas:\n- Tecido de alta densidade\n- Tamanho XL: 900x400mm\n- Bordas costuradas\n- Base antiderrapante\n- Espessura de 4mm\n- Resistente a água', 129.90, 30, 3, 0, 'https://images.pexels.com/photos/6894528/pexels-photo-6894528.jpeg'),

('ProAim X2 Wireless Gaming Mouse', 'Mouse gamer sem fio com tecnologia de conexão de 2.4GHz para zero lag, sensor de 25000 DPI e autonomia de bateria de até 70 horas.\n\nPesa apenas 79g e possui design ergonômico pensado para longas sessões de jogo com conforto máximo.\n\nCaracterísticas:\n- Conexão sem fio de 2.4GHz\n- Sensor ótico de 25000 DPI\n- Autonomia de até 70 horas\n- Peso de 79g\n- 7 botões programáveis\n- Design ergonômico', 399.90, 10, 1, 1, 'https://images.pexels.com/photos/5391372/pexels-photo-5391372.jpeg'),

('ProAim K2 TKL Teclado Mecânico', 'Teclado mecânico TKL (Tenkeyless) com formato compacto, switches Red silenciosos e responsivos, ideal para games que exigem movimentos rápidos.\n\nDesign sem teclado numérico para economizar espaço e permitir posicionamento mais ergonômico durante o jogo.\n\nCaracterísticas:\n- Layout TKL (sem teclado numérico)\n- Switches mecânicos Red\n- Iluminação RGB\n- Keycaps em PBT de dupla injeção\n- Cabo USB-C destacável\n- Construção em alumínio aeronáutico', 349.90, 20, 2, 0, 'https://images.pexels.com/photos/1772123/pexels-photo-1772123.jpeg'),

('ProAim Control Mousepad', 'Mousepad de tamanho médio (450x400mm) com superfície de tecido texturizado para maior controle e precisão em movimentos detalhados.\n\nIdeal para jogadores que preferem sensibilidade mais alta e precisam de maior controle sobre o mouse.\n\nCaracterísticas:\n- Tecido texturizado de alta densidade\n- Tamanho médio: 450x400mm\n- Espessura de 3mm\n- Bordas costuradas\n- Base antiderrapante reforçada\n- Design exclusivo ProAim', 89.90, 35, 3, 0, 'https://images.pexels.com/photos/1337247/pexels-photo-1337247.jpeg');