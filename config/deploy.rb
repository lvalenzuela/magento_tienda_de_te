set :application, "Magento Tienda de Té"
set :repository,  "git@github.com:lvalenzuela/magento_tienda_de_te.git"
set :deploy_to, "/var/www/html/magento-tienda-de-te"
set :scm, :git
set :branch, "master"
set :user, "ubuntu"
set :group, "deployers"
set :use_sudo, false
set :rails_env, "production"
set :deploy_via, :copy
set :ssh_options, { :forward_agent => true }
set :keep_releases, 5
default_run_options[:pty] = true
 
# set :scm, :git # You can set :scm explicitly or Capistrano will make an intelligent guess based on known version control directory names
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `git`, `mercurial`, `perforce`, `subversion` or `none`

role :web, "50.16.0.56"                          # Your HTTP server, Apache/etc
role :app, "50.16.0.56"                          # This may be the same as your `Web` server
role :db,  "50.16.0.56", :primary => true 		# This is where Rails migrations will run

task :generate_symlinks do
	run ["ln -nfs #{shared_path}/config/local.xml #{release_path}/app/etc/local.xml"]
end

# if you want to clean up old releases on each deploy uncomment this:
# after "deploy:restart", "deploy:cleanup"

# if you're still using the script/reaper helper you will need
# these http://github.com/rails/irs_process_scripts

# If you are using Passenger mod_rails uncomment this:
# namespace :deploy do
#   task :start do ; end
#   task :stop do ; end
#   task :restart, :roles => :app, :except => { :no_release => true } do
#     run "#{try_sudo} touch #{File.join(current_path,'tmp','restart.txt')}"
#   end
# end